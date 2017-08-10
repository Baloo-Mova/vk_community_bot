<?php

namespace App\Console;

use App\Console\Commands\AutoDelivery;
use App\Console\Commands\MassDelivery;
use App\Console\Commands\MessageListener;
use App\Console\Commands\SubscriptionCheck;
use App\Console\Commands\TelegramUpdates;
use App\Console\Commands\Test;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Test::class,
        MassDelivery::class,
        AutoDelivery::class,
        SubscriptionCheck::class,
        TelegramUpdates::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
