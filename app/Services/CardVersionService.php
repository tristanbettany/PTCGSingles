<?php

namespace App\Services;

use App\Interfaces\CardVersionServiceInterface;
use App\Interfaces\ValueScraperInterface;
use App\Models\OnHandCard;
use App\Models\ReleasedCardVersion;
use App\Scrapers\MagicMadhouseValueScraper;

final class CardVersionService extends AbstractService implements CardVersionServiceInterface
{
    public const VALUE_SCRAPERS = [
        MagicMadhouseValueScraper::class,
    ];

    public function updateVersionQuantity(
        int $versionId,
        int $quantity
    ): int {
        $version = $this->getVersionById($versionId);
        $onHandCards = $version->onHandCards;

        if (
            empty($onHandCards) === true
            || $onHandCards->count() < 1
        ) {
            $onHandCard = OnHandCard::create([
                'released_card_version_id' => $version->id,
                'quantity' => $quantity,
            ]);
        } else {
            $onHandCard = $onHandCards->first();
            $onHandCard->quantity = $quantity;
            $onHandCard->save();
        }

        return $onHandCard->quantity;
    }

    public function getVersionById(int $versionId): ?ReleasedCardVersion
    {
        return ReleasedCardVersion::query()
            ->where('id', $versionId)
            ->first();
    }

    public function scrapeValue(int $versionId): float
    {
        $version = $this->getVersionById($versionId);

        $values = [];
        foreach (self::VALUE_SCRAPERS as $valueScraper) {
            /** @var ValueScraperInterface $scraper */
            $scraper = new $valueScraper();
            $values[] = $scraper->scrapeValue($version);
        }

        $values = array_filter($values);
        $arrayCount = count($values);
        $arraySum = array_sum($values);

        if (
            empty($values) === false
            && $arrayCount > 0
            && $arraySum > 0
        ) {
            $averageValue = $arraySum / $arrayCount;

            $version->value = $averageValue;
            $version->save();

            return $averageValue;
        }

        return $version->value ?? 00.00;
    }
}
