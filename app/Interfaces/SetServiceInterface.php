<?php

namespace App\Interfaces;

use App\Models\Set;
use Illuminate\Support\Collection;

interface SetServiceInterface
{
    public function getSet(int $id): Set;
    public function getLatestSets(): Collection;
}
