<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [];

    protected function schedule(Schedule $schedule): void
    {
        // TODO: Define commands to run on a schedule
        // See: https://laravel.com/docs/8.x/scheduling#scheduling-artisan-commands
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
