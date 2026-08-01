<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    private const BACKUP_DIR = 'backups';

    public function index()
    {
        Storage::disk('local')->makeDirectory(self::BACKUP_DIR);

        $backups = collect(Storage::disk('local')->files(self::BACKUP_DIR))
            ->filter(fn ($file) => str_ends_with($file, '.sql'))
            ->map(function ($file) {
                return [
                    'name' => basename($file),
                    'size' => round(Storage::disk('local')->size($file) / 1024, 1), // KB
                    'date' => Storage::disk('local')->lastModified($file),
                ];
            })
            ->sortByDesc('date')
            ->values();

        return view('backup.index', compact('backups'));
    }

    public function create()
    {
        $disk = Storage::disk('local');
        $disk->makeDirectory(self::BACKUP_DIR);

        $filename = 'opticare-backup-' . now()->format('Y-m-d_His') . '.sql';

        // FIX: use the disk's own path() resolver instead of manually
        // building storage_path('app/...') -- in Laravel 11+, the 'local'
        // disk's root moved to storage/app/private, so hardcoding
        // storage_path('app/...') pointed to the wrong folder and made
        // download()/exists() unable to find the file.
        $fullPath = $disk->path(self::BACKUP_DIR . '/' . $filename);

        $driver = DB::connection()->getDriverName();

        $command = $driver === 'pgsql'
            ? $this->buildPgDumpCommand($fullPath)
            : $this->buildMysqldumpCommand($fullPath);
exec($command, $output, $resultCode);

dd([
    'command' => $command,
    'resultCode' => $resultCode,
    'output' => $output,
    'error' => shell_exec($command . ' 2>&1'),
]);
        if ($resultCode !== 0 || !file_exists($fullPath) || filesize($fullPath) === 0) {
            // Clean up an empty/failed file so it doesn't clutter the list
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            $tool = $driver === 'pgsql' ? 'pg_dump' : 'mysqldump';

            return back()->with(
                'error',
                "Backup failed. Make sure {$tool} is installed and accessible on this server."
            );
        }

        return back()->with('success', 'Backup created successfully: ' . $filename);
    }

    /**
     * Backup command for MySQL/MariaDB (local XAMPP setup).
     */
   private function buildPgDumpCommand(string $fullPath): string
{
    $db = config('database.connections.pgsql');

    putenv("PGPASSWORD={$db['password']}");

    $pgDumpPath = env('PGDUMP_PATH', '/usr/bin/pg_dump');

    return sprintf(
        '%s -h %s -p %s -U %s -F p -d %s -f %s',
        $pgDumpPath,
        $db['host'],
        $db['port'],
        $db['username'],
        $db['database'],
        $fullPath
    );
}
    /**
     * Backup command for PostgreSQL (Render deployment).
     */
    private function buildPgDumpCommand(string $fullPath): string
    {
        $db = config('database.connections.pgsql');

        // pg_dump doesn't accept a plaintext --password flag the way
        // mysqldump does -- the standard way to pass it non-interactively
        // is the PGPASSWORD environment variable.
        putenv('PGPASSWORD=' . $db['password']);

        // Set PGDUMP_PATH in .env if pg_dump isn't on the server's PATH.
   $pgDumpPath = env('PGDUMP_PATH', '/usr/bin/pg_dump');

        return sprintf(
            '%s --host=%s --port=%s --username=%s --no-password --format=plain %s > %s 2>&1',
            escapeshellarg($pgDumpPath),
            escapeshellarg($db['host']),
            escapeshellarg($db['port'] ?? 5432),
            escapeshellarg($db['username']),
            escapeshellarg($db['database']),
            escapeshellarg($fullPath)
        );
    }

    public function download(string $filename)
    {
        $path = self::BACKUP_DIR . '/' . basename($filename);

        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->download($path);
    }

    public function destroy(string $filename)
    {
        $path = self::BACKUP_DIR . '/' . basename($filename);
        Storage::disk('local')->delete($path);

        return back()->with('success', 'Backup file deleted.');
    }
}