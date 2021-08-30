<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface SeriesServiceInterface
{
    public function getAll(): Collection;
}
