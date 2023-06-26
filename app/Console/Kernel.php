<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
         $schedule->call(function(){
             Log::info('updating database...');
             exec('mysqldump -u '. env('DB_USERNAME').' -p'.env('DB_PASSWORD').' --databases '.env('DB_DATABASE').' > /home/fikkie/backups/'.Carbon::now()->format('Y-m-d H:i').'.sql');
         })->weeklyOn(1, '12:00')->timezone('Europe/Amsterdam');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
