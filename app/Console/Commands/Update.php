<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'updates the app';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        exec('./scripts/update.sh '.env('DB_BACKUP_FOLDER').' '.env('DB_USERNAME').' '.env('DB_PASSWORD').' '.env('DB_DATABASE'));
    }
}
