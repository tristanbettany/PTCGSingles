<?php

namespace App\Interfaces;

use App\Models\ReleasedCardVersion;

interface CardVersionServiceInterface
{
    public function updateVersionQuantity(
        int $versionId,
        int $quantity
    ): int;

    public function getVersionById(int $versionId): ?ReleasedCardVersion;
}
