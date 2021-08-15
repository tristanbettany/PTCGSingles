<?php

namespace App\Interfaces;

interface ScraperServiceInterface
{
    public function scrapeNewData(bool $verbose = false): void;
}
