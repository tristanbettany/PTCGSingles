<?php

namespace App\Scrapers;

use App\Interfaces\NewCardScraperInterface;

abstract class AbstractNewCardScraper implements NewCardScraperInterface
{
    private array $cards = [];

    public function downloadCards(): void
    {
        // TODO: Implement downloadRecords() method.
    }

    public function saveCards(): void
    {
        // TODO: Implement saveRecords() method.
    }

    public function getCards(): array
    {
        return $this->cards;
    }
}
