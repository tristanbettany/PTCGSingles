<?php

namespace App\Scrapers;

use App\Models\Rarity;
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

                            $existingCard = ReleasedCard::query()
                                ->where('name', $name)
                                ->where('set_id', $set->id)
                                ->first();

                            if ($existingCard !== null) {
                                if ($verbose === true) {
                                    echo "Found: '$name' for set: '$set->name' in database, skipping card scrape \n";
                                }
                                continue;
                            }

                            if ($verbose === true) {
                                echo "Scraping card: '$name' for set '$set->name'\n";
                            }

                            $cardBody = $this->scrape(self::BASE_URL . $cardLink);

                            $cardArray = [
                                'rarity' => $this->getRarity($cardBody),
                                'number' => $this->getCardNumber($cardBody),
                                'name' => $name,
                                'set_id' => $set->id,
                                'data_source_url' => self::BASE_URL . $cardLink,
                                'image' => $this->getCardImage($cardBody),
                            ];

                            $this->saveCard($cardArray, $verbose);

                            if ($this->hasReverseHolo($cardBody) === true) {
                                $cardArray2 = array_merge(
                                    $cardArray,
                                    [
                                        'is_reverse_holo' => true,
                                    ]
                                );

                                $this->saveCard($cardArray2, $verbose);
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
    ): void {
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

        $existingCard = ReleasedCard::query()
            ->where('name', $card['name'])
            ->where('set_id', $card['set_id'])
            ->first();

        if ($existingCard === null) {
            $createdCard = ReleasedCard::create($card);
            if ($verbose === true) {
                echo "Saved: " . $card['name'] . " \n";
            }
        }
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

    private function getCardNumber(string $cardBody): ?string
    {
        preg_match("#Card:.+\"\>(\d+)\/#", $cardBody, $cardNumberMatch);

        if (empty($cardNumberMatch[1]) === false) {
            return $cardNumberMatch[1];
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
