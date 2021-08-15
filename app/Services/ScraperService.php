<?php

namespace App\Services;

use App\Interfaces\SetScraperInterface;
use App\Interfaces\ScraperServiceInterface;
use App\Scrapers\PokellectorSetScraper;

final class ScraperService extends AbstractService implements ScraperServiceInterface
{
    public const SET_SCRAPERS = [
        PokellectorSetScraper::class,
    ];

    public function scrape(bool $verbose = false): void
    {
        foreach(self::SET_SCRAPERS as $setScraper){
            /** @var SetScraperInterface $scraper */
            $scraper = new $setScraper();
            $scraper->scrapeSets($verbose);
            $scraper->saveSets($verbose);
        }
    }
}
