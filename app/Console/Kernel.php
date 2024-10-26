<?php

namespace App\Console;

use App\Console\Commands\SendDailyEventNotificationsCommand;
use App\Console\Commands\SendEventNotifications5minCommand;
use App\Console\Commands\SendEventNotificationsCommand;
use App\Console\Commands\SendNextDayEventNotificationsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(SendEventNotificationsCommand::class)->everyMinute();
        $schedule->command(SendEventNotifications5minCommand::class)->everyMinute();
        $schedule->command(SendDailyEventNotificationsCommand::class)->dailyAt('08:00');
        $schedule->command(SendNextDayEventNotificationsCommand::class)->dailyAt('22:00');
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
