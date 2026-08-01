<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    private const BACKUP_DIR = 'backups';

    public function index()
    {
        Storage::disk('local')->makeDirectory(self::BACKUP_DIR);

        $backups = collect(Storage::disk('local')->files(self::BACKUP_DIR))
            ->filter(fn($file) => str_ends_with($file, '.sql'))
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

        $command = $driver === 'pgsql'
            ? $this->buildPgDumpCommand($fullPath)
            : $this->buildMysqldumpCommand($fullPath);

        exec($command . ' 2>&1', $output, $resultCode);

        if ($resultCode !== 0 || !file_exists($fullPath) || filesize($fullPath) === 0) {

            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            return back()->with('error', implode("\n", $output));
        }

        return back()->with('success', 'Backup created successfully.');
    }

    private function buildMysqldumpCommand(string $fullPath): string
    {
        $db = config('database.connections.mysql');

        return sprintf(
            '%s --user=%s --password=%s --host=%s %s > %s',
            escapeshellcmd(env('MYSQLDUMP_PATH', 'mysqldump')),
            escapeshellarg($db['username']),
            escapeshellarg($db['password']),
            escapeshellarg($db['host']),
            escapeshellarg($db['database']),
            escapeshellarg($fullPath)
        );
    }

    private function buildPgDumpCommand(string $fullPath): string
    {
        $db = config('database.connections.pgsql');

        putenv("PGPASSWORD={$db['password']}");

        return sprintf(
            '%s -h %s -p %s -U %s -F p -d %s -f %s',
            escapeshellcmd(env('PGDUMP_PATH', '/usr/lib/postgresql/18/bin/pg_dump')),
            escapeshellarg($db['host']),
            escapeshellarg($db['port']),
            escapeshellarg($db['username']),
            escapeshellarg($db['database']),
            escapeshellarg($fullPath)
        );
    }

        /**
     * Download Backup
     */
    public function download(string $filename)
    {
        $path = self::BACKUP_DIR . '/' . basename($filename);

        if (!Storage::disk('local')->exists($path)) {
            abort(404, 'Backup file not found.');
        }

        return Storage::disk('local')->download($path);
    }

    /**
     * Delete Backup
     */
    public function destroy(string $filename)
    {
        $path = self::BACKUP_DIR . '/' . basename($filename);

        if (Storage::disk('local')->exists($path)) {
            Storage::disk('local')->delete($path);
        }

        return back()->with('success', 'Backup deleted successfully.');
    }

    /**
     * Restore Page
     */
    public function restoreForm()
    {
        return view('backup.restore');
    }

    /**
     * Restore Database
     */
    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:sql|max:51200',
        ]);

        $file = $request->file('backup_file');

        $tempPath = $file->storeAs(
            self::BACKUP_DIR,
            'restore_' . time() . '.sql',
            'local'
        );

        $fullPath = Storage::disk('local')->path($tempPath);

        $driver = DB::connection()->getDriverName();

        if ($driver === 'pgsql') {

            $db = config('database.connections.pgsql');

            putenv("PGPASSWORD={$db['password']}");

            $command = sprintf(
                '%s -h %s -p %s -U %s -d %s -f %s',
                escapeshellcmd(env('PSQL_PATH', '/usr/lib/postgresql/18/bin/psql')),
                escapeshellarg($db['host']),
                escapeshellarg($db['port']),
                escapeshellarg($db['username']),
                escapeshellarg($db['database']),
                escapeshellarg($fullPath)
            );

        } else {

            $db = config('database.connections.mysql');

            $command = sprintf(
                '%s --user=%s --password=%s %s < %s',
                escapeshellcmd(env('MYSQL_PATH', 'mysql')),
                escapeshellarg($db['username']),
                escapeshellarg($db['password']),
                escapeshellarg($db['database']),
                escapeshellarg($fullPath)
            );
        }

        exec($command . ' 2>&1', $output, $resultCode);

        Storage::disk('local')->delete($tempPath);

        if ($resultCode !== 0) {
            return back()->with('error', implode("\n", $output));
        }

        return back()->with('success', 'Database restored successfully.');
    }

    /**
     * Schedule Page
     */
    public function schedule()
    {
        return view('backup.schedule');
    }

    /**
     * Save Schedule
     */
    public function saveSchedule(Request $request)
    {
        $request->validate([
            'frequency' => 'required|in:daily,weekly,monthly',
            'time' => 'required'
        ]);

        return redirect()
            ->route('backup.schedule')
            ->with('success', 'Backup schedule saved successfully.');
    }
}