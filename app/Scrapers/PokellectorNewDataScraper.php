<?php

namespace App\Scrapers;

use DateTimeImmutable;
use RuntimeException;

final class PokellectorNewDataScraper extends AbstractNewDataScraper
{
    private ?string $setsBody;
    private ?string $setBody;

    public function downloadSets(): void
    {
        $this->setsBody = $this->scrape('https://www.pokellector.com/sets');
    }

    public function processSets(bool $verbose = false): void
    {
        if (empty($this->setsBody) === false) {
            preg_match_all("#\<a.+button.+\/sets\/.+a\>#", $this->setsBody, $matches);

            if (empty($matches[0]) === false) {
                $setLinks = $matches[0];

                foreach ($setLinks as $key => $setLink) {
                    $name = $this->getSetName($setLink);

                    if ($verbose === true) {
                        echo "Scraping $name \n";
                    }

                    //TODO: Check if set exists in db already and skip if it does

                    $this->downloadSet($this->getSetUrl($setLink));

                    preg_match("#(<div class=\"cards\".+)<h1#sU", $this->setBody, $match);

                    $this->sets[] = array_merge(
                        [
                            'name' => $name,
                            'logo' => $this->getSetLogo($setLink),
                            'symbol' => $this->getSetSymbol($setLink),
                        ],
                        $this->getSetInfo($match[1])
                    );

                    if ($verbose === true) {
                        echo "Scraped $name \n";
                    }
                }
            }
        }
    }

    private function downloadSet(string $relativeUrl): void
    {
        $this->setBody = $this->scrape('https://www.pokellector.com' . $relativeUrl);
    }

    private function getSetInfo(string $setInfoSection): array
    {
        $array = [];

        preg_match_all("#\<span\>(.+)\<\/span\>#", $setInfoSection, $matchesOne);

        if(empty($matchesOne[1][1]) === false) {
            $array['baseCardCount'] = (int) $matchesOne[1][1];
        }

        preg_match_all("#\<cite\>(.+)\<\/cite\>#", $setInfoSection, $matchesTwo);

        if(empty($matchesTwo[1][0]) === false) {
            if (
                str_contains($matchesTwo[1][0], '+') === true
                || str_contains($matchesTwo[1][0], 'Secret') === true
            ) {
                $secretCount = str_replace('+', '', $matchesTwo[1][0]);
                $secretCount = str_replace('Secret', '', $secretCount);

                $array['secretCardCount'] = (int) trim($secretCount);
            } else {
                $array['secretCardCount'] = 0;
                $array['releaseDate'] = new DateTimeImmutable($matchesOne[1][3] . $matchesTwo[1][0]);
            }
        }

        if(empty($matchesOne[1][3]) === false) {
            if(empty($matchesTwo[1][1]) === false) {
                $array['releaseDate'] = new DateTimeImmutable($matchesOne[1][3] . $matchesTwo[1][1]);
            }
        }

        return $array;
    }

    private function getSetName(string $setLink): ?string
    {
        preg_match("#\<span\>(.+)\<\/span\>#", $setLink, $match);

        if (empty($match[1]) === false) {
            return $match[1];
        }

        return null;
    }

    private function getSetLogo(string $setLink): ?string
    {
        preg_match("#\<img src=\"(.+)\"\>\<img#", $setLink, $match);

        if (empty($match[1]) === false) {
            return $this->downloadFile($match[1]);
        }

        return null;
    }

    private function getSetSymbol(string $setLink): ?string
    {
        preg_match("#\"symbol\"\ssrc=\"(.+)\"\stitle#", $setLink, $match);

        if (empty($match[1]) === false) {
            return $this->downloadFile($match[1]);
        }

        return null;
    }

    private function getSetUrl(string $setLink): ?string
    {
        preg_match("#href=\"(.+)\"\>\<img\ssrc#", $setLink, $match);

        if (empty($match[1]) === false) {
            return $match[1];
        }

        return null;
    }
}
