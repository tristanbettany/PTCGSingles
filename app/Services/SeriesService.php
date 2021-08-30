<?php

namespace App\Services;

use App\Interfaces\SeriesServiceInterface;
use App\Models\Series;
use Illuminate\Support\Collection;

final class SeriesService extends AbstractService implements SeriesServiceInterface
{
    public function getAll(): Collection
    {
        return Series::all();
    }
}
