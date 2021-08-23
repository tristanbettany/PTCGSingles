<?php

namespace App\Scrapers;

use App\Interfaces\ScraperInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Exception;

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
        $disk = 'local';
        if ($isPublic === true) {
            $disk = 'public';
        }

        $filename = basename($url);
        if (Storage::disk($disk)->exists($filename) === true) {
            return $filename;
        }

        $headers = get_headers($url);
        if (str_contains($headers[0], '200 OK') !== true) {
            throw new Exception('Unable to download file');
        }

        $fileContents = file_get_contents($url);

        Storage::disk($disk)->put(
            $filename,
            $fileContents
        );

        return $filename;
    }

    protected function scrape(string $url): string
    {
        $response = $this->guzzle->request(
            'GET',
            $url,
            [
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36',
                ],
            ]
        );

        return $response->getBody()->getContents();
    }
}
