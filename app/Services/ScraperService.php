<?php

namespace App\Services;

use App\Interfaces\ScraperServiceInterface;
use App\Scrapers\PokellectorNewRecordScraper;

final class ScraperService extends AbstractService implements ScraperServiceInterface
{
    public const NEW_RECORD_SCRAPERS = [
        PokellectorNewRecordScraper::class,
    ];

    public function scrapeNewRecords(): void
    {
        /**
         * loop each new record scraper
         * download records
         * save scraped records
         */
    }
}
