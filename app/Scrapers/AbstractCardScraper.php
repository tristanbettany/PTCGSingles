<?php

namespace App\Scrapers;

use App\Interfaces\CardScraperInterface;

abstract class AbstractCardScraper extends AbstractScraper implements CardScraperInterface
{
    protected array $cards = [];

    public function scrapeCards(bool $verbose = false): void
    {
        // TODO: Implement processSets() method.
    }

    public function saveCards(bool $verbose = false): void
    {
        // TODO: Implement saveSets() method.
    }
}
