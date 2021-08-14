<?php

namespace App\Scrapers;

use App\Interfaces\NewRecordScraperInterface;

final class PokellectorNewRecordScraper implements NewRecordScraperInterface
{
    public function getRecords(): array
    {
        return [];
    }
}
