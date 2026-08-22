@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold">
                <i class="bi bi-clock-history text-warning"></i>
                Automatic Backup
            </h2>
            <p class="text-muted">
                Configure automatic database backups.
            </p>
        </div>

        <a href="{{ route('backup.index') }}"
           class="btn btn-secondary rounded-pill">
            <i class="bi bi-arrow-left"></i>
            Back
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            <strong>Please correct the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body p-4">

            <form action="{{ route('backup.schedule.save') }}"
                  method="POST">

                @csrf

                <div class="mb-4">
                    <div class="form-check form-switch fs-5">
                        <input class="form-check-input"
                               type="checkbox"
                               role="switch"
                               id="enabled"
                               name="enabled"
                               value="1"
                               {{ old('enabled', $schedule['enabled'] ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold fs-6 align-middle" for="enabled">
                            Enable Automatic Backups
                        </label>
                    </div>
                    <small class="text-muted d-block ms-1">
                        When enabled, scheduled backups will automatically execute via the Laravel task scheduler.
                    </small>
                </div>

                <div class="mb-3">
                    <label for="frequency" class="form-label fw-semibold">
                        Backup Frequency
                    </label>
                    <select
                        class="form-select"
                        id="frequency"
                        name="frequency"
                        required>
                        <option value="daily" {{ old('frequency', $schedule['frequency'] ?? 'daily') === 'daily' ? 'selected' : '' }}>
                            Daily
                        </option>
                        <option value="weekly" {{ old('frequency', $schedule['frequency'] ?? 'daily') === 'weekly' ? 'selected' : '' }}>
                            Weekly
                        </option>
                        <option value="monthly" {{ old('frequency', $schedule['frequency'] ?? 'daily') === 'monthly' ? 'selected' : '' }}>
                            Monthly
                        </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="time" class="form-label fw-semibold">
                        Backup Time
                    </label>
                    <input
                        type="time"
                        id="time"
                        name="time"
                        class="form-control"
                        value="{{ old('time', $schedule['time'] ?? '01:00') }}"
                        required>
                    <small class="text-muted">
                        Select the time of day (24-hour format) when the backup should run.
                    </small>
                </div>

                <button
                    type="submit"
                    class="btn btn-warning rounded-pill px-4 fw-semibold">
                    <i class="bi bi-save me-1"></i>
                    Save Schedule
                </button>

            </form>

            <hr class="my-4">

            <div class="alert {{ ($schedule['enabled'] ?? true) ? 'alert-info' : 'alert-secondary' }} mb-0 rounded-3">

                <div class="d-flex align-items-center justify-content-between mb-2">
                    <strong>Current Status</strong>
                    @if($schedule['enabled'] ?? true)
                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Active</span>
                    @else
                        <span class="badge bg-secondary"><i class="bi bi-pause-circle me-1"></i>Disabled</span>
                    @endif
                </div>

                @if($schedule['enabled'] ?? true)
                    <p class="mb-2">
                        Automatic Backup is currently <strong>Enabled</strong> and scheduled to run <strong>{{ ucfirst($schedule['frequency'] ?? 'daily') }}</strong> at <strong>{{ $schedule['time'] ?? '01:00' }}</strong>.
                    </p>
                @else
                    <p class="mb-2 text-muted">
                        Automatic Backup is currently <strong>Disabled</strong>. No automated backups will run until enabled.
                    </p>
                @endif

                @if(!empty($schedule['updated_at']))
                    <p class="small text-muted mb-2">
                        Last configured: {{ \Carbon\Carbon::parse($schedule['updated_at'])->format('M d, Y g:i A') }}
                    </p>
                @endif

                <div class="pt-2 border-top border-opacity-25 border-secondary small">
                    Make sure your server cron job is running:
                    <div class="mt-1">
                        <code>php artisan schedule:run</code>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection