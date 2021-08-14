<?php

namespace App\Services;

use App\Interfaces\NewRecordScraperInterface;
use App\Interfaces\ScraperServiceInterface;
use App\Scrapers\PokellectorNewRecordScraper;

final class ScraperService extends AbstractService implements ScraperServiceInterface
{
    public const NEW_RECORD_SCRAPERS = [
        PokellectorNewRecordScraper::class,
    ];

    public function scrapeNewRecords(): void
    {
        foreach(self::NEW_RECORD_SCRAPERS as $scraperClass){
            /** @var NewRecordScraperInterface $scraper */
            $scraper = new $scraperClass();
            $scraper->downloadRecords();
            $scraper->saveRecords();
        }
    }
}
