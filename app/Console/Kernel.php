<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
{
    // Send event notifications every hour
    $schedule->command('notifications:send-event-reminders')
             ->hourly()
             ->withoutOverlapping();
    
    // Clean up old read notifications (older than 30 days)
    $schedule->call(function () {
        \App\Models\Notification::where('read_at', '<', now()->subDays(30))->delete();
    })->daily();
}

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
