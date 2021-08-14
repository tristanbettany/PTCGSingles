<?php

namespace App\Interfaces;

interface NewCardScraperInterface
{
    public function downloadCards(): void;
    public function saveCards(): void;
    public function getCards(): array;
}
