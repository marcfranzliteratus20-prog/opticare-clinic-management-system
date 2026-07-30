<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

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

        $db = config('database.connections.mysql');

        // NOTE: on XAMPP/Windows, mysqldump.exe is often NOT on the system
        // PATH. Set MYSQLDUMP_PATH in your .env to the full path, e.g.:
        // MYSQLDUMP_PATH="C:\xampp\mysql\bin\mysqldump.exe"
        $mysqldumpPath = env('MYSQLDUMP_PATH', 'mysqldump');

        $command = sprintf(
            '%s --user=%s --password=%s --host=%s %s > %s 2>&1',
            escapeshellarg($mysqldumpPath),
            escapeshellarg($db['username']),
            escapeshellarg($db['password']),
            escapeshellarg($db['host']),
            escapeshellarg($db['database']),
            escapeshellarg($fullPath)
        );

        exec($command, $output, $resultCode);

        if ($resultCode !== 0 || !file_exists($fullPath) || filesize($fullPath) === 0) {
            // Clean up an empty/failed file so it doesn't clutter the list
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            return back()->with(
                'error',
                'Backup failed. Make sure mysqldump is installed and MYSQLDUMP_PATH is set correctly in your .env file.'
            );
        }

        return back()->with('success', 'Backup created successfully: ' . $filename);
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