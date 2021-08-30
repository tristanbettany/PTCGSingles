<?php

namespace App\Providers;

use App\Interfaces\CardServiceInterface;
use App\Interfaces\CardVersionServiceInterface;
use App\Interfaces\ScraperServiceInterface;
use App\Interfaces\SeriesServiceInterface;
use App\Interfaces\SetServiceInterface;
use App\Services\CardService;
use App\Services\CardVersionService;
use App\Services\ScraperService;
use App\Services\SeriesService;
use App\Services\SetService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private const BINDINGS = [
        ScraperServiceInterface::class => ScraperService::class,
        CardVersionServiceInterface::class => CardVersionService::class,
        SetServiceInterface::class => SetService::class,
        SeriesServiceInterface::class => SeriesService::class,
        CardServiceInterface::class => CardService::class,
    ];

    public function register(): void
    {
        foreach (self::BINDINGS as $interface => $concreteImplementation) {
            $this->app->bind(
                $interface,
                $concreteImplementation
            );
        }
    }

    public function boot(): void
    {
        //TODO: Bootstrap app services
    }
}
