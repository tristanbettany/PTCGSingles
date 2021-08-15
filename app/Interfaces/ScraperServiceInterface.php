<?php

namespace App\Interfaces;

interface ScraperServiceInterface
{
    public function scrape(bool $verbose = false): void;
}
