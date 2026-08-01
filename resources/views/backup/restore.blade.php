@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                <i class="bi bi-arrow-counterclockwise text-success"></i>
                Restore Database
            </h2>
            <p class="text-muted">
                Upload a previously downloaded SQL backup to restore the clinic database.
            </p>
        </div>

        <a href="{{ route('backup.index') }}" class="btn btn-secondary rounded-pill">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger rounded-3">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body">

            <form action="{{ route('backup.restore') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        SQL Backup File
                    </label>

                    <input
                        type="file"
                        name="backup_file"
                        class="form-control"
                        accept=".sql"
                        required>

                </div>

                <div class="alert alert-warning">

                    <strong>Warning:</strong>

                    Restoring a database may overwrite your current data.
                    Make sure you have created a recent backup before continuing.

                </div>

                <button class="btn btn-success rounded-pill px-4">

                    <i class="bi bi-upload"></i>

                    Restore Database

                </button>

            </form>

        </div>

    </div>

</div>
@endsection