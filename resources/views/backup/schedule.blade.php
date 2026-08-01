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
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body">

            <form action="{{ route('backup.schedule.save') }}"
                  method="POST">

                @csrf

                <div class="mb-3">

                    <label class="form-label fw-semibold">

                        Backup Frequency

                    </label>

                    <select
                        class="form-select"
                        name="frequency">

                        <option value="daily">
                            Daily
                        </option>

                        <option value="weekly">
                            Weekly
                        </option>

                        <option value="monthly">
                            Monthly
                        </option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label fw-semibold">

                        Backup Time

                    </label>

                    <input
                        type="time"
                        name="time"
                        class="form-control"
                        value="01:00">

                </div>

                <button
                    class="btn btn-warning rounded-pill px-4">

                    <i class="bi bi-save"></i>

                    Save Schedule

                </button>

            </form>

            <hr>

            <div class="alert alert-info mb-0">

                <strong>Current Status</strong>

                <br><br>

                Automatic Backup is enabled through Laravel Scheduler.

                <br>

                Make sure your server cron job is running:

                <br><br>

                <code>
                php artisan schedule:run
                </code>

            </div>

        </div>

    </div>

</div>
@endsection