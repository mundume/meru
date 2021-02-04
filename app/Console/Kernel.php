<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //
    ];
    protected function schedule(Schedule $schedule) {
        $schedule->command('xwift:book')->everyMinute()->withoutOverlapping();  
        $schedule->command('notify:admin')->dailyAt('20:00');
        $schedule->command('update:calendarial')->dailyAt('01:00');
        $schedule->command('delete:calendarial')->dailyAt('11:50'); 
    }
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
