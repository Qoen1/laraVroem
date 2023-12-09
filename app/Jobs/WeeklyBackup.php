<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class WeeklyBackup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
	    $query = 'mysqldump -u '. env('DB_USERNAME').' -p'.env('DB_PASSWORD').' --databases '.env('DB_DATABASE').' > '.env('DB_BACKUP_FOLDER', '.').'/"'.Carbon::now()->format('Y-m-d H:i').'.sql"';
        Log::info('updating database: '.$query);
        exec('mysqldump -u '. env('DB_USERNAME').' -p'.env('DB_PASSWORD').' --databases '.env('DB_DATABASE').' > '.env('DB_BACKUP_FOLDER', '.').'/"'.Carbon::now()->format('Y-m-d H:i').'.sql"');
    }
}
