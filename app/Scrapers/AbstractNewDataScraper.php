<?php

namespace App\Scrapers;

use App\Interfaces\NewDataScraperInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

abstract class AbstractNewDataScraper implements NewDataScraperInterface
{
    protected array $sets = [];
    protected array $cards = [];
    protected Client $guzzle;

    public function __construct()
    {
        $this->guzzle = new Client();
    }

    public function downloadSets(): void
    {
        // TODO: Implement downloadSets() method.
    }

    public function processSets(bool $verbose = false): void
    {
        // TODO: Implement processSets() method.
    }

    public function saveSets(bool $verbose = false): void
    {
        // TODO: Implement saveSets() method.
    }

    public function downloadCards(): void
    {
        // TODO: Implement downloadRecords() method.
    }

    public function processCards(): void
    {
        // TODO: Implement processCards() method.
    }

    public function saveCards(): void
    {
        // TODO: Implement saveRecords() method.
    }

    public function getSets(): array
    {
        return $this->sets;
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    protected function downloadFile(string $url): string
    {
        sleep(1);

        $headers = get_headers($url);
        if (str_contains($headers[0], '200 OK') !== true) {
            throw new RuntimeException('Unable to download file');
        }

        sleep(1);

        $fileContents = file_get_contents($url);
        $filename = basename($url);

        Storage::disk()->put(
            $filename,
            $fileContents
        );

        return $filename;
    }

    protected function scrape(string $url): string
    {
        sleep(2);

        $response = $this->guzzle->request(
            'GET',
            $url
        );

        return $response->getBody()->getContents();
    }
}
