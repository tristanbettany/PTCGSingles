<?php

namespace App\Services;

use App\Interfaces\SetServiceInterface;

final class SetService extends AbstractService implements SetServiceInterface
{
    public const FILTER_OPTIONS = [
        'None',
        'Cards With Versions In Stock (Got)',
        'Cards Missing Version Stock (Need)',
        'Expensive Cards First',
        'Cards Above 1 GBP',
        'All VMAX Cards',
        'All V Cards',
        'All Special and Secret Cards'
    ];
}
