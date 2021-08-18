<?php

namespace App\Scrapers;

use App\Interfaces\SetScraperInterface;

abstract class AbstractSetScraper extends AbstractScraper implements SetScraperInterface
{
    public function scrapeSets(bool $verbose = false): void
    {
        // TODO: Implement processSets() method.
    }
}
