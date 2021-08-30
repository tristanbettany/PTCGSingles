<?php

namespace App\Interfaces;

use App\Models\Set;
use Illuminate\Support\Collection;

interface SetServiceInterface
{
    public function getSet(int $id): Set;
    public function getLatestSets(): Collection;
    public function getSwapsList(int $setId): array;
    public function getNeedsList(int $setId): array;
    public function exportSwaps(int $setId): void;
    public function exportNeeds(int $setId): void;
}
