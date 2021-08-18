<?php

namespace App\Services;

use App\Interfaces\CardScraperInterface;
use App\Interfaces\SetScraperInterface;
use App\Interfaces\ScraperServiceInterface;
use App\Scrapers\PokellectorCardScraper;
use App\Scrapers\PokellectorSetScraper;

final class ScraperService extends AbstractService implements ScraperServiceInterface
{
    public const SET_SCRAPERS = [
        PokellectorSetScraper::class,
    ];

    public const CARD_SCRAPERS = [
        PokellectorCardScraper::class,
    ];

    public function scrape(bool $verbose = false): void
    {
        foreach(self::SET_SCRAPERS as $setScraper){
            /** @var SetScraperInterface $scraper */
            $scraper = new $setScraper();
            $scraper->scrapeSets($verbose);
        }

        foreach(self::CARD_SCRAPERS as $cardScraper){
            /** @var CardScraperInterface $scraper */
            $scraper = new $cardScraper();
            $scraper->scrapeCards($verbose);
        }
    }
}
