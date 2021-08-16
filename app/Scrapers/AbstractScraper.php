<?php

namespace App\Scrapers;

use App\Interfaces\ScraperInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

abstract class AbstractScraper implements ScraperInterface
{
    protected Client $guzzle;

    public function __construct()
    {
        $this->guzzle = new Client();
    }

    protected function downloadFile(
        string $url,
        bool $isPublic = false
    ): string {
        $headers = get_headers($url);
        if (str_contains($headers[0], '200 OK') !== true) {
            throw new RuntimeException('Unable to download file');
        }

        sleep(rand(1, 2));

        $fileContents = file_get_contents($url);

        $pathinfo = pathinfo($url);
        $filename = uniqid() . '.' . $pathinfo['extension'];

        $disk = 'local';
        if ($isPublic === true) {
            $disk = 'public';
        }

        Storage::disk($disk)->put(
            $filename,
            $fileContents
        );

        return $filename;
    }

    protected function scrape(string $url): string
    {
        sleep(rand(2, 5));

        $response = $this->guzzle->request(
            'GET',
            $url
        );

        return $response->getBody()->getContents();
    }
}