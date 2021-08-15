<?php

namespace App\Services;

use App\Interfaces\NewDataScraperInterface;
use App\Interfaces\ScraperServiceInterface;
use App\Scrapers\PokellectorNewDataScraper;

final class ScraperService extends AbstractService implements ScraperServiceInterface
{
    public const NEW_RECORD_SCRAPERS = [
        PokellectorNewDataScraper::class,
    ];

    public function scrapeNewData(bool $verbose = false): void
    {
        foreach(self::NEW_RECORD_SCRAPERS as $scraperClass){
            /** @var NewDataScraperInterface $scraper */
            $scraper = new $scraperClass();
            $scraper->downloadSets();
            $scraper->processSets($verbose);
            $scraper->saveSets();

            $scraper->downloadCards();
            $scraper->processCards();
            $scraper->saveCards();
        }
    }
}
