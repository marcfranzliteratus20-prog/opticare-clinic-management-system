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
                    'size' => round(Storage::disk('local')->size($file) / 1024, 1),
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
        $fullPath = $disk->path(self::BACKUP_DIR . '/' . $filename);

        $driver = DB::connection()->getDriverName();

        if ($driver === 'pgsql') {
            $command = $this->buildPgDumpCommand($fullPath);
        } else {
            $command = $this->buildMysqldumpCommand($fullPath);
        }

        exec($command . ' 2>&1', $output, $resultCode);

        if ($resultCode !== 0 || !file_exists($fullPath) || filesize($fullPath) === 0) {

            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            return back()->with(
                'error',
                implode("\n", $output)
            );
        }

        return back()->with(
            'success',
            'Backup created successfully: ' . $filename
        );
    }

    /**
     * MySQL Backup
     */
    private function buildMysqldumpCommand(string $fullPath): string
    {
        $db = config('database.connections.mysql');

        $mysqldump = env('MYSQLDUMP_PATH', 'mysqldump');

        return sprintf(
            '%s --user=%s --password=%s --host=%s %s > %s',
            escapeshellcmd($mysqldump),
            escapeshellarg($db['username']),
            escapeshellarg($db['password']),
            escapeshellarg($db['host']),
            escapeshellarg($db['database']),
            escapeshellarg($fullPath)
        );
    }

    /**
     * PostgreSQL Backup
     */
    private function buildPgDumpCommand(string $fullPath): string
    {
        $db = config('database.connections.pgsql');

        putenv("PGPASSWORD={$db['password']}");

        $pgDump = env('PGDUMP_PATH', '/usr/bin/pg_dump');

        return sprintf(
            '%s -h %s -p %s -U %s -F p -d %s -f %s',
            escapeshellcmd($pgDump),
            escapeshellarg($db['host']),
            escapeshellarg($db['port']),
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

        if (Storage::disk('local')->exists($path)) {
            Storage::disk('local')->delete($path);
        }

        return back()->with('success', 'Backup file deleted.');
    }
}