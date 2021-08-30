<?php

namespace App\Services;

use App\Interfaces\SetServiceInterface;
use App\Models\Set;
use Illuminate\Support\Collection;
use DateTimeImmutable;

final class SetService extends AbstractService implements SetServiceInterface
{
    public const NONE = 'None';
    public const GOT = 'Cards With Versions In Stock (Got)';
    public const NEED = 'Cards Missing Version Stock (Need)';
    public const EXP = 'Expensive Cards First';
    public const ABO = 'Cards Above 1 GBP';
    public const AVMAX = 'All VMAX Cards';
    public const AV = 'All V Cards';

    public const FILTER_OPTIONS = [
        self::NONE,
        self::GOT,
        self::NEED,
        self::EXP,
        self::ABO,
        self::AVMAX,
        self::AV
    ];

    public function getSet(int $id): Set
    {
        return Set::find($id);
    }

    public function getLatestSets(): Collection
    {
        Set::query()
            ->where('release_date', '>=', new DateTimeImmutable('2 years ago'))
            ->get();
    }
}
