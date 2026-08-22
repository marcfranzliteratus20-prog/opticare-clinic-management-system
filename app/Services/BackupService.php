<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupService
{
    public const BACKUP_DIR = 'backups';
    public const SCHEDULE_FILE = 'backup_schedule.json';

    /**
     * Get the configured schedule settings.
     */
    public function getSchedule(): array
    {
        $disk = Storage::disk('local');

        if ($disk->exists(self::SCHEDULE_FILE)) {
            try {
                $content = $disk->get(self::SCHEDULE_FILE);
                $decoded = json_decode($content, true);

                if (is_array($decoded)) {
                    return [
                        'enabled' => (bool) ($decoded['enabled'] ?? true),
                        'frequency' => (string) ($decoded['frequency'] ?? 'daily'),
                        'time' => (string) ($decoded['time'] ?? '01:00'),
                        'updated_at' => $decoded['updated_at'] ?? null,
                    ];
                }
            } catch (\Throwable $e) {
                // Return defaults on read failure
            }
        }

        return [
            'enabled' => true,
            'frequency' => 'daily',
            'time' => '01:00',
            'updated_at' => null,
        ];
    }

    /**
     * Save the backup schedule settings.
     */
    public function saveSchedule(array $data): array
    {
        $schedule = [
            'enabled' => isset($data['enabled']) ? (bool) $data['enabled'] : true,
            'frequency' => in_array($data['frequency'] ?? '', ['daily', 'weekly', 'monthly'], true)
                ? $data['frequency']
                : 'daily',
            'time' => !empty($data['time']) ? (string) $data['time'] : '01:00',
            'updated_at' => now()->toIso8601String(),
        ];

        Storage::disk('local')->put(
            self::SCHEDULE_FILE,
            json_encode($schedule, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );

        return $schedule;
    }

    /**
     * Create a new database backup.
     */
    public function createBackup(): array
    {
        $disk = Storage::disk('local');
        $disk->makeDirectory(self::BACKUP_DIR);

        $filename = 'opticare-backup-' . now()->format('Y-m-d_His') . '.sql';
        $fullPath = $disk->path(self::BACKUP_DIR . '/' . $filename);

        $driver = DB::connection()->getDriverName();

        $command = $driver === 'pgsql'
            ? $this->buildPgDumpCommand($fullPath)
            : $this->buildMysqldumpCommand($fullPath);

        exec($command . ' 2>&1', $output, $resultCode);

        if ($resultCode !== 0 || !file_exists($fullPath) || filesize($fullPath) === 0) {
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            return [
                'success' => false,
                'message' => !empty($output) ? implode("\n", $output) : 'Backup command failed to generate a valid SQL file.',
                'filename' => null,
            ];
        }

        return [
            'success' => true,
            'message' => 'Backup created successfully.',
            'filename' => $filename,
        ];
    }

    /**
     * Build mysqldump command.
     */
    private function buildMysqldumpCommand(string $fullPath): string
    {
        $db = config('database.connections.mysql');

        return sprintf(
            '%s --user=%s --password=%s --host=%s %s > %s',
            escapeshellcmd(env('MYSQLDUMP_PATH', 'mysqldump')),
            escapeshellarg($db['username'] ?? 'root'),
            escapeshellarg($db['password'] ?? ''),
            escapeshellarg($db['host'] ?? '127.0.0.1'),
            escapeshellarg($db['database'] ?? 'opticare'),
            escapeshellarg($fullPath)
        );
    }

    /**
     * Build pg_dump command.
     */
    private function buildPgDumpCommand(string $fullPath): string
    {
        $db = config('database.connections.pgsql');

        putenv("PGPASSWORD=" . ($db['password'] ?? ''));

        return sprintf(
            '%s -h %s -p %s -U %s -F p -d %s -f %s',
            escapeshellcmd(env('PGDUMP_PATH', '/usr/lib/postgresql/18/bin/pg_dump')),
            escapeshellarg($db['host'] ?? '127.0.0.1'),
            escapeshellarg($db['port'] ?? '5432'),
            escapeshellarg($db['username'] ?? 'postgres'),
            escapeshellarg($db['database'] ?? 'opticare'),
            escapeshellarg($fullPath)
        );
    }
}
