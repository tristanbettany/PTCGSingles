<?php

namespace App\Scrapers;

use App\Models\Set;
use DateTimeImmutable;
use Exception;

final class PokellectorSetScraper extends AbstractSetScraper
{
    private const BASE_URL = 'https://www.pokellector.com';

    public function scrapeSets(bool $verbose = false): void
    {
        try {
            $setsBody = $this->scrape(self::BASE_URL . '/sets');

            if (empty($setsBody) === false) {
                preg_match_all("#<a.+button.+\/sets\/.+a>#", $setsBody, $matches);

                if (empty($matches[0]) === false) {
                    $setLinks = $matches[0];

                    foreach ($setLinks as $key => $setLink) {
                        $name = $this->getSetName($setLink);

                        $existingSet = Set::query()
                            ->where('name', $name)
                            ->first();

                        if ($existingSet !== null) {
                            if ($verbose === true) {
                                echo "Found: '$name' in database, skipping set scrape \n";
                            }
                            continue;
                        }

                        if ($verbose === true) {
                            echo "Scraping set: $name \n";
                        }

                        $setUrl = $this->getSetUrl($setLink);
                        $setBody = $this->scrape($setUrl);

                        preg_match("#(<div class=\"cards\".+)<h1#sU", $setBody, $match);

                        $this->sets[] = array_merge(
                            [
                                'name' => $name,
                                'logo' => $this->getSetLogo($setLink),
                                'symbol' => $this->getSetSymbol($setLink),
                                'data_source_url' => $setUrl,
                            ],
                            $this->getSetInfo($match[1])
                        );
                    }
                }
            }
        } catch (Exception $e) {
            echo "Something went wrong! Saving sets in memory... \n";
            $this->saveSets();
            echo "\n\n ------- Exception Message -------- \n\n" . $e->getMessage() . " \n\n";
        }
    }

    public function saveSets(bool $verbose = false): void
    {
        foreach($this->sets as $set) {
            $createdSet = Set::create($set);
            if ($verbose === true) {
                echo "Saved: ". $set['name'] ." \n";
            }
        }
    }

    private function getSetInfo(string $setInfoSection): array
    {
        $array = [];

        preg_match_all("#<span>(.+)<\/span>#", $setInfoSection, $matchesOne);

        if(empty($matchesOne[1][1]) === false) {
            $array['base_card_count'] = (int) $matchesOne[1][1];
        }

        preg_match_all("#<cite>(.+)<\/cite>#", $setInfoSection, $matchesTwo);

        if(empty($matchesTwo[1][0]) === false) {
            if (
                str_contains($matchesTwo[1][0], '+') === true
                || str_contains($matchesTwo[1][0], 'Secret') === true
            ) {
                $secretCount = str_replace('+', '', $matchesTwo[1][0]);
                $secretCount = str_replace('Secret', '', $secretCount);

                $array['secret_card_count'] = (int) trim($secretCount);
            } else {
                $array['secret_card_count'] = 0;
                $array['release_date'] = new DateTimeImmutable($matchesOne[1][3] . $matchesTwo[1][0]);
            }
        }

        if(empty($matchesOne[1][3]) === false) {
            if(empty($matchesTwo[1][1]) === false) {
                $array['release_date'] = new DateTimeImmutable($matchesOne[1][3] . $matchesTwo[1][1]);
            }
        }

        return $array;
    }

    private function getSetName(string $setLink): ?string
    {
        preg_match("#<span>(.+)<\/span>#", $setLink, $match);

        if (empty($match[1]) === false) {
            return $match[1];
        }

        return null;
    }

    private function getSetLogo(string $setLink): ?string
    {
        preg_match("#<img src=\"(.+)\"><img#", $setLink, $match);

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
        preg_match("#href=\"(.+)\"\stitle.+><img\ssrc#", $setLink, $match);

        if (empty($match[1]) === false) {
            return self::BASE_URL . $match[1];
        }

        return null;
    }
}
