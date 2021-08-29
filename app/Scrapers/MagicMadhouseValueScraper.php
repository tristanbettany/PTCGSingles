<?php

namespace App\Scrapers;

use App\Models\ReleasedCardVersion;

final class MagicMadhouseValueScraper extends AbstractValueScraper
{
    private const BASE_URL = 'https://www.magicmadhouse.co.uk/autocomplete/search/json';

    public function scrapeValue(ReleasedCardVersion $version): float
    {
        $query = $this->buildQuery($version);
        $searchResults = $this->search($query);
        $value = $this->parseSearchResultsForValue($searchResults, $version);

        return $value;
    }

    private function parseSearchResultsForValue(
        array $searchResults,
        ReleasedCardVersion $version
    ): float {
        $value = 00.00;
        if (empty($searchResults) === false) {
            $card = $version->releasedCard;
            $cardNumber = $card->paddedNumber();
            $cardCount = $card->set->base_card_count;
            $cardName = $card->name;
            $setName = $card->set->name;

            foreach ($searchResults['products'] as $product) {
                if (
                    str_contains($product['title'], $setName) === true
                    && str_contains($product['title'], "$cardNumber/$cardCount") === true
                    && str_contains($product['title'], $cardName) === true
                ) {
                    if (
                        str_contains($product['title'], '(Reverse Holo)') === true
                        && $version->is_reverse_holo === false
                    ) {
                        continue;
                    }

                    $priceHtml = $product['price'];
                    preg_match("#product-content__price--inc.+£(.+)\<#Us", $priceHtml, $priceMatch);
                    if (empty($priceMatch[1]) === false) {
                        $value = $priceMatch[1];
                        break;
                    }
                }
            }
        }

        return (float) $value;
    }

    private function buildQuery(ReleasedCardVersion $version): string
    {
        $card = $version->releasedCard;

        $cardNumber = $card->paddedNumber();
        $cardName = $card->name;
        $setName = $card->set->name;

        return "$setName $cardName $cardNumber";
    }

    private function search(string $query): array
    {
        $json = $this->scrape(
            self::BASE_URL,
            [
                'q' => $query,
            ]
        );

        return json_decode($json, true);
    }
}
