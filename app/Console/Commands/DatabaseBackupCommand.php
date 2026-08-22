<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BackupService;

class DatabaseBackupCommand extends Command
{
    protected $signature = 'backup:database';

    protected $description = 'Create automatic database backup';

    public function handle(BackupService $backupService): int
    {
        $this->info('Starting database backup...');

        $result = $backupService->createBackup();

        if ($result['success']) {
            $this->info('Automatic backup completed successfully: ' . ($result['filename'] ?? ''));
            return Command::SUCCESS;
        }

        $this->error('Automatic backup failed: ' . ($result['message'] ?? 'Unknown error'));
        return Command::FAILURE;
    }
}