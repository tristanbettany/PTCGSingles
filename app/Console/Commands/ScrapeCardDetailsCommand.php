<?php

namespace App\Console\Commands;

use App\Interfaces\ScraperServiceInterface;
use Illuminate\Console\Command;

class ScrapeCardDetailsCommand extends Command
{
    protected $signature = 'scrape';
    protected $description = 'Scrape Card details';

    private ScraperServiceInterface $scraperService;

    public function handle(
        ScraperServiceInterface $scraperService
    ): int {
        $this->scraperService = $scraperService;

        $this->info('Scraping data...');

        $this->scraperService->scrapeNewRecords();

        $this->info('Done');
    }
}
