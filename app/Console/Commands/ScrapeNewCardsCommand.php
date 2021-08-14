<?php

namespace App\Console\Commands;

use App\Interfaces\ScraperServiceInterface;
use Illuminate\Console\Command;

class ScrapeNewCardsCommand extends Command
{
    protected $signature = 'scrape:new';
    protected $description = 'Scrape New Cards';

    private ScraperServiceInterface $scraperService;

    public function handle(
        ScraperServiceInterface $scraperService
    ): int {
        $this->scraperService = $scraperService;

        $this->info('Scraping new records...');

        $this->scraperService->scrapeNewCards();

        $this->info('Done');
    }
}
