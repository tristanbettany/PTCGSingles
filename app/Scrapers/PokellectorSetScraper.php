<?php

namespace App\Scrapers;

use App\Models\Series;
use App\Models\Set;
use DateTimeImmutable;
use Exception;

final class PokellectorSetScraper extends AbstractSetScraper
{
    private const BASE_URL = 'https://www.pokellector.com';

    public function scrapeSets(
        string $exitAtSeries = 'XY',
        bool $verbose = false
    ): void {
        try {
            $setsBody = $this->scrape(self::BASE_URL . '/sets');

            if (empty($setsBody) === false) {
                preg_match_all("#<a.+button.+\/sets\/.+a>#", $setsBody, $setLinkMatches);

                if (empty($setLinkMatches[0]) === false) {
                    $setLinks = $setLinkMatches[0];

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

                        preg_match("#(<div\sclass=\"cards\".+)<h1#sU", $setBody, $setInfoMatch);
                        preg_match("#(<div\sclass=\"breadcrumbs\">.+)<h1#sU", $setBody, $setBreadCrumbMatch);

                        $series = $this->getSetSeries(trim($setBreadCrumbMatch[1]));

                        if ($series === $exitAtSeries) {
                            echo "No More series required, exiting set scrape...\n";
                            break;
                        }

                        $set = array_merge(
                            [
                                'name' => $name,
                                'logo' => $this->getSetLogo($setLink),
                                'symbol' => $this->getSetSymbol($setLink),
                                'data_source_url' => $setUrl,
                                'series' => $series,
                            ],
                            $this->getSetInfo($setInfoMatch[1])
                        );

                        $this->saveSet($set, $verbose);
                    }
                }
            }
        } catch (Exception $e) {
            echo "Something went wrong!... \n";
            echo "\n\n ------- Exception Message -------- \n\n" . $e->getMessage() . " \n\n";
        }
    }

    private function saveSet(
        array $set,
        bool $verbose = false
    ): void {
        $existingSeries = Series::query()
            ->where('name', $set['series'])
            ->first();

        if ($existingSeries === null) {
            $series = Series::create([
                'name' => $set['series'],
            ]);
            $set['series_id'] = $series->id;
        } else {
            $set['series_id'] = $existingSeries->id;
        }

        unset($set['series']);

        $existingSet = Set::query()
            ->where('name', $set['name'])
            ->first();

        if ($existingSet === null) {
            $createdSet = Set::create($set);
            if ($verbose === true) {
                echo "Saved: " . $set['name'] . " \n";
            }
        }
    }

    private function getSetSeries(string $setBreadCrumbs): ?string
    {
        preg_match_all("#<a\shref=\".+\">(.+)<\/a>#U", $setBreadCrumbs, $matches);

        if (empty($matches[1][1]) === false) {
            return trim(str_replace('Series', '', $matches[1][1]));
        }

        return null;
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
        preg_match("#<img\ssrc=\"(.+)\"><img#", $setLink, $match);

        if (empty($match[1]) === false) {
            return $this->downloadFile($match[1], true);
        }

        return null;
    }

    private function getSetSymbol(string $setLink): ?string
    {
        preg_match("#\"symbol\"\ssrc=\"(.+)\"\stitle#", $setLink, $match);

        if (empty($match[1]) === false) {
            return $this->downloadFile($match[1], true);
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
