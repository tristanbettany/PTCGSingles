<?php

namespace App\Providers;

use App\Interfaces\CardVersionServiceInterface;
use App\Interfaces\ScraperServiceInterface;
use App\Services\CardVersionService;
use App\Services\ScraperService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private const BINDINGS = [
        ScraperServiceInterface::class => ScraperService::class,
        CardVersionServiceInterface::class => CardVersionService::class,
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
