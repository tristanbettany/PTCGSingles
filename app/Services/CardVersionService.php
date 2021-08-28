<?php

namespace App\Services;

use App\Interfaces\CardVersionServiceInterface;
use App\Models\OnHandCard;
use App\Models\ReleasedCardVersion;

final class CardVersionService extends AbstractService implements CardVersionServiceInterface
{
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
}
