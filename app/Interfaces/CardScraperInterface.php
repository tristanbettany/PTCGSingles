<?php

namespace App\Interfaces;

interface CardScraperInterface
{
    public function scrapeCards(bool $verbose = false): void;
}
