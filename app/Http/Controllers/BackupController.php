<?php

namespace App\Http\Controllers;

use App\Services\BackupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    private const BACKUP_DIR = BackupService::BACKUP_DIR;

    public function __construct(
        protected BackupService $backupService
    ) {}

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
        $result = $this->backupService->createBackup();

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
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

            putenv("PGPASSWORD=" . ($db['password'] ?? ''));

            $command = sprintf(
                '%s -h %s -p %s -U %s -d %s -f %s',
                escapeshellcmd(env('PSQL_PATH', '/usr/lib/postgresql/18/bin/psql')),
                escapeshellarg($db['host'] ?? '127.0.0.1'),
                escapeshellarg($db['port'] ?? '5432'),
                escapeshellarg($db['username'] ?? 'postgres'),
                escapeshellarg($db['database'] ?? 'opticare'),
                escapeshellarg($fullPath)
            );

        } else {

            $db = config('database.connections.mysql');

            $command = sprintf(
                '%s --user=%s --password=%s %s < %s',
                escapeshellcmd(env('MYSQL_PATH', 'mysql')),
                escapeshellarg($db['username'] ?? 'root'),
                escapeshellarg($db['password'] ?? ''),
                escapeshellarg($db['database'] ?? 'opticare'),
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
        $schedule = $this->backupService->getSchedule();

        return view('backup.schedule', compact('schedule'));
    }

    /**
     * Save Schedule
     */
    public function saveSchedule(Request $request)
    {
        $validated = $request->validate([
            'frequency' => 'required|in:daily,weekly,monthly',
            'time' => 'required',
            'enabled' => 'nullable',
        ]);

        $enabled = $request->has('enabled')
            ? filter_var($request->input('enabled'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? true
            : false;

        $this->backupService->saveSchedule([
            'enabled' => $enabled,
            'frequency' => $validated['frequency'],
            'time' => $validated['time'],
        ]);

        return redirect()
            ->route('backup.schedule')
            ->with('success', 'Backup schedule saved successfully.');
    }
}