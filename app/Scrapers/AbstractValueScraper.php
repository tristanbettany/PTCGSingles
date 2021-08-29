<?php

namespace App\Scrapers;

use App\Interfaces\ValueScraperInterface;
use App\Models\ReleasedCardVersion;

abstract class AbstractValueScraper extends AbstractScraper implements ValueScraperInterface
{
    public function scrapeValue(ReleasedCardVersion $version): float
    {
        // TODO: Implement scrapeValue() method.
    }
}
