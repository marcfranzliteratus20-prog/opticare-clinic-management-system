<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Services\BackupService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Dynamic Automatic Database Backup Scheduler
try {
    $backupService = app(BackupService::class);
    $scheduleConfig = $backupService->getSchedule();

    if (!empty($scheduleConfig['enabled'])) {
        $frequency = $scheduleConfig['frequency'] ?? 'daily';
        $time = $scheduleConfig['time'] ?? '01:00';

        $event = Schedule::command('backup:database');

        match ($frequency) {
            'weekly' => $event->weekly()->at($time),
            'monthly' => $event->monthly()->at($time),
            default => $event->dailyAt($time),
        };
    }
} catch (\Throwable $e) {
    // Avoid crashing console commands during bootstrapping
}
