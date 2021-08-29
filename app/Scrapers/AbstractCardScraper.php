<?php

namespace App\Scrapers;

use App\Interfaces\CardScraperInterface;

abstract class AbstractCardScraper extends AbstractScraper implements CardScraperInterface
{
    public function scrapeCards(bool $verbose = false): void
    {
        // TODO: Implement scrapeCards() method.
    }
}
