<?php

namespace App\Interfaces;

interface CardScraperInterface
{
    public function scrapeCards(bool $verbose = false): void;
    public function saveCards(bool $verbose = false): void;
}
