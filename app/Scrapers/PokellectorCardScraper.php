<?php

namespace App\Scrapers;

use App\Models\Rarity;
use App\Models\ReleasedCard;
use App\Models\ReleasedCardVersion;
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
                    preg_match_all("#<a href=\"(\/card.+)\"\sname=\".+title=\"(.+)\s-\s.+\#(\d+)\"\>#", $setBody, $cardLinkMatches);

                    if (empty($cardLinkMatches[1]) === false) {
                        $cardLinks = $cardLinkMatches[1];

                        foreach ($cardLinks as $key => $cardLink) {
                            $name = 'Unknown Card';
                            $number = 0;

                            if (empty($cardLinkMatches[2][$key]) === false) {
                                $name = $cardLinkMatches[2][$key];
                            }

                            if (empty($cardLinkMatches[3][$key]) === false) {
                                $number = $cardLinkMatches[3][$key];
                            }

                            $existingCard = ReleasedCard::query()
                                ->where('name', $name)
                                ->where('set_id', $set->id)
                                ->where('number', $number)
                                ->first();

                            if ($existingCard !== null) {
                                if ($verbose === true) {
                                    echo "Found: $name $number/$set->base_card_count ($set->name) in database, skipping card scrape \n";
                                }
                                continue;
                            }

                            if ($verbose === true) {
                                echo "Scraping card: $name $number/$set->base_card_count ($set->name) \n";
                            }

                            $cardBody = $this->scrape(self::BASE_URL . $cardLink);

                            $cardArray = [
                                'rarity' => $this->getRarity($cardBody),
                                'number' => $number,
                                'name' => $name,
                                'set_id' => $set->id,
                                'data_source_url' => self::BASE_URL . $cardLink,
                                'image' => $this->getCardImage($cardBody),
                            ];

                            $releasedCard = $this->saveCard($cardArray, $verbose);
                            ReleasedCardVersion::create([
                                'released_card_id' => $releasedCard->id,
                            ]);

                            if ($this->hasReverseHolo($cardBody) === true) {
                                ReleasedCardVersion::create([
                                    'released_card_id' => $releasedCard->id,
                                    'is_standard' => false,
                                    'is_reverse_holo' => true,
                                ]);
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            echo "Something went wrong!... \n";
            echo "\n\n ------- Exception Message -------- \n\n" . $e->getMessage() . " \n\n";
        }
    }

    private function saveCard(
        array $card,
        bool $verbose = false
    ): ReleasedCard {
        $existingRarity = Rarity::query()
            ->where('name', $card['rarity'])
            ->first();

        if ($existingRarity === null) {
            $rarity = Rarity::create([
                'name' => $card['rarity'],
            ]);
            $card['rarity_id'] = $rarity->id;
        } else {
            $card['rarity_id'] = $existingRarity->id;
        }

        unset($card['rarity']);

        $cardObject = ReleasedCard::query()
            ->where('name', $card['name'])
            ->where('set_id', $card['set_id'])
            ->where('number', $card['number'])
            ->first();

        if ($cardObject === null) {
            $cardObject = ReleasedCard::create($card);
            if ($verbose === true) {
                echo "Saved: " . $card['name'] . " \n";
            }
        }

        return $cardObject;
    }

    private function getCardImage(string $cardBody): ?string
    {
        preg_match("#og:image.+content=\"(.+)\"\>#", $cardBody, $match);

        if (empty($match[1]) === false) {
            return $this->downloadFile($match[1], true);
        }

        return null;
    }

    private function getRarity(string $cardBody): ?string
    {
        preg_match("#Rarity:<\/strong\>\s(.+)\<\/div\>#", $cardBody, $rarityMatch);

        if (empty($rarityMatch[1]) === false) {
            return $rarityMatch[1];
        }

        return null;
    }

    private function hasReverseHolo(string $cardBody): bool
    {
        preg_match("#\>(Reverse Holo)\<#", $cardBody, $reverseHoloMatch);

        if (empty($reverseHoloMatch[1]) === false) {
            return true;
        }

        return false;
    }
}
