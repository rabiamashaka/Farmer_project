<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\SendTestBulkSms::class,
        \App\Console\Commands\SendTestSingleSms::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('weather:fetch')->everyTenMinutes()->withoutOverlapping();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
