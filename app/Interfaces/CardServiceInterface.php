<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface CardServiceInterface
{
    public function getReleasedCardsQuery(): Builder;
    public function filterBySet(
        int $setId,
        Builder $query
    ): Builder;
    public function filterByRequest(
        Request $request,
        Builder $query
    ): Builder;
    public function sortByRequest(
        Request $request,
        Builder $query
    ): Collection;
}
