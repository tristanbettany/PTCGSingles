<?php

namespace App\Services;

use App\Interfaces\NewCardScraperInterface;
use App\Interfaces\ScraperServiceInterface;
use App\Scrapers\PokellectorNewCardScraper;

final class ScraperService extends AbstractService implements ScraperServiceInterface
{
    public const NEW_RECORD_SCRAPERS = [
        PokellectorNewCardScraper::class,
    ];

    public function scrapeNewCards(): void
    {
        foreach(self::NEW_RECORD_SCRAPERS as $scraperClass){
            /** @var NewCardScraperInterface $scraper */
            $scraper = new $scraperClass();
            $scraper->downloadCards();
            $scraper->saveCards();
        }
    }
}
