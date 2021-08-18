<?php

namespace App\Interfaces;

interface SetScraperInterface
{
    public function scrapeSets(
        string $exitAtSeries = 'XY',
        bool $verbose = false
    ): void;
}
