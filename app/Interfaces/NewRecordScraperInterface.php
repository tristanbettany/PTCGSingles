<?php

namespace App\Interfaces;

interface NewRecordScraperInterface
{
    public function downloadRecords(): void;
    public function saveRecords(): void;
    public function getRecords(): array;
}
