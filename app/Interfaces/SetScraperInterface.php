<?php

namespace App\Interfaces;

interface SetScraperInterface
{
    public function scrapeSets(bool $verbose = false): void;
}
