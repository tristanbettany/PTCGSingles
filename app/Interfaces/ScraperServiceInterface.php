<?php

namespace App\Interfaces;

interface ScraperServiceInterface
{
    public function scrape(
        string $exitAtSeries = 'XY',
        bool $verbose = false
    ): void;
}
