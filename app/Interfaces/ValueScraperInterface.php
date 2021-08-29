<?php

namespace App\Interfaces;

use App\Models\ReleasedCardVersion;

interface ValueScraperInterface
{
    public function scrapeValue(ReleasedCardVersion $version): float;
}
