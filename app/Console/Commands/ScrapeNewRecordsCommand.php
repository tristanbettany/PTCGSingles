<?php

namespace App\Console\Commands;

use App\Interfaces\ScraperServiceInterface;
use Illuminate\Console\Command;

class ScrapeNewRecordsCommand extends Command
{
    protected $signature = 'scrape:new';
    protected $description = 'Scrape New Records';

    private ScraperServiceInterface $scraperService;

    public function handle(
        ScraperServiceInterface $scraperService
    ): int {
        $this->scraperService = $scraperService;

        $this->info('Scraping new records...');

        $this->scraperService->scrapeNewRecords();

        $this->info('Done');
    }
}
