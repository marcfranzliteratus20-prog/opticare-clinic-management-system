<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\BackupController;

class DatabaseBackupCommand extends Command
{
    protected $signature = 'backup:database';

    protected $description = 'Create automatic database backup';

    public function handle()
    {
        $controller = new BackupController();

        $controller->create();

        $this->info('Automatic backup completed.');

        return Command::SUCCESS;
    }
}