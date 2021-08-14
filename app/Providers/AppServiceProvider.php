<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    private const BINDINGS = [

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
