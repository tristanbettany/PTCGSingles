<?php

namespace App\Scrapers;

use App\Models\ReleasedCard;
use App\Models\Set;
use Exception;

final class PokellectorCardScraper extends AbstractCardScraper
{
    private const BASE_URL = 'https://www.pokellector.com';

    public function scrapeCards(bool $verbose = false): void
    {
        try {
            $sets = Set::all();

            foreach ($sets as $set) {
                $setBody = $this->scrape($set->data_source_url);

                if (empty($setBody) === false) {
                    preg_match_all("#<a href=\"(\/card.+)\"\sname=\".+title=\"(.+)\s-#", $setBody, $cardLinkMatches);

                    if (empty($cardLinkMatches[1]) === false) {
                        $cardLinks = $cardLinkMatches[1];

                        foreach ($cardLinks as $key => $cardLink) {
                            $name = 'Unknown Card';

                            if (empty($cardLinkMatches[2][$key]) === false) {
                                $name = $cardLinkMatches[2][$key];
                            }

                            if ($verbose === true) {
                                echo "Scraping card: $name \n";
                            }

                            $cardBody = $this->scrape(self::BASE_URL . $cardLink);

                            $this->cards[] = array_merge(
                                $this->getStandardCardInfo($cardBody),
                                $this->getAlternateCardsInfo($cardBody),
                                [
                                    'data_source_url' => self::BASE_URL . $cardLink,
                                ],
                            );
                        }
                    }
                }

                break;
            }
        } catch (Exception $e) {
            echo "Something went wrong! Saving cards in memory... \n";
            $this->saveCards();
            echo "\n\n ------- Exception Message -------- \n\n" . $e->getMessage() . " \n\n";
        }
    }

    public function saveCards(bool $verbose = false): void
    {

    }

    private function getStandardCardInfo(string $cardBody): array
    {
        $array = [];



        return $array;
    }

    private function getAlternateCardsInfo(string $cardBody): array
    {
        $array = [];



        return $array;
    }
}
