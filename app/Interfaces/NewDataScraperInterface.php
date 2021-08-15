<?php

namespace App\Interfaces;

interface NewDataScraperInterface
{
    public function downloadSets(): void;
    public function processSets(bool $verbose = false): void;
    public function saveSets(): void;
    public function downloadCards(): void;
    public function processCards(): void;
    public function saveCards(): void;
    public function getSets(): array;
    public function getCards(): array;
}
