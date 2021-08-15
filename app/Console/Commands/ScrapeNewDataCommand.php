<?php

namespace App\Console\Commands;

use App\Interfaces\ScraperServiceInterface;
use Illuminate\Console\Command;

class ScrapeNewDataCommand extends Command
{
    protected $signature = 'scrape:new';
    protected $description = 'Scrape New Data';

    private ScraperServiceInterface $scraperService;

    public function handle(
        ScraperServiceInterface $scraperService
    ): int {
        $this->scraperService = $scraperService;

        $this->info('Scraping new data...');

        $this->scraperService->scrapeNewData(true);

        $this->info('Done');

        return 0;
    }
}
