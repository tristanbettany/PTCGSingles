<?php

namespace App\Scrapers;

use App\Interfaces\NewRecordScraperInterface;

final class PokellectorNewRecordScraper implements NewRecordScraperInterface
{
    private array $records = [];

    public function downloadRecords(): void
    {
        // TODO: Implement downloadRecords() method.
    }

    public function saveRecords(): void
    {
        // TODO: Implement saveRecords() method.
    }

    public function getRecords(): array
    {
        return $this->records;
    }
}
