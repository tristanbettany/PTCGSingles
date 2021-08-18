<?php

namespace App\Scrapers;

use App\Interfaces\SetScraperInterface;

abstract class AbstractSetScraper extends AbstractScraper implements SetScraperInterface
{
    public function scrapeSets(
        string $exitAtSeries = 'XY',
        bool $verbose = false
    ): void {
        // TODO: Implement processSets() method.
    }
}
