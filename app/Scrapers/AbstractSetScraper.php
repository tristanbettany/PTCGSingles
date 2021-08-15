<?php

namespace App\Scrapers;

use App\Interfaces\SetScraperInterface;

abstract class AbstractSetScraper extends AbstractScraper implements SetScraperInterface
{
    protected array $sets = [];

    public function scrapeSets(bool $verbose = false): void
    {
        // TODO: Implement processSets() method.
    }

    public function saveSets(bool $verbose = false): void
    {
        // TODO: Implement saveSets() method.
    }
}
