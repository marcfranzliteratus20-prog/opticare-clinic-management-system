@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">💾 Database Backup</h2>
            <p class="text-muted mb-0">Create and manage downloadable backups of the clinic database.</p>
        </div>

      <div class="d-flex gap-2">

    <form action="{{ route('backup.create') }}" method="POST">
        @csrf
        <button class="btn btn-primary rounded-pill">
            <i class="bi bi-hdd-stack"></i>
            Backup Now
        </button>
    </form>

    <a href="{{ route('backup.restore.form') }}"
       class="btn btn-success rounded-pill">
        <i class="bi bi-arrow-counterclockwise"></i>
        Restore Database
    </a>

    <a href="{{ route('backup.schedule') }}"
       class="btn btn-warning rounded-pill">
        <i class="bi bi-clock-history"></i>
        Automatic Backup
    </a>

</div>

    @if(session('success'))
        <div class="alert alert-success rounded-3">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger rounded-3">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th>Size</th>
                        <th>Date Created</th>
                        <th width="220">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($backups as $backup)
                        <tr>
                            <td>{{ $backup['name'] }}</td>
                            <td>{{ $backup['size'] }} KB</td>
                            <td>{{ \Carbon\Carbon::createFromTimestamp($backup['date'])->format('M d, Y g:i A') }}</td>
                            <td>

    <a href="{{ route('backup.download',$backup['name']) }}"
       class="btn btn-outline-primary btn-sm">
        Download
    </a>

    <form
        action="{{ route('backup.destroy',$backup['name']) }}"
        method="POST"
        class="d-inline">

        @csrf
        @method('DELETE')

        <button
            class="btn btn-outline-danger btn-sm"
            onclick="return confirm('Delete backup?')">

            Delete

        </button>

    </form>

</td>
                                <form action="{{ route('backup.restore', $backup['name']) }}" method="POST" class="d-inline">
    @csrf
    <button class="btn btn-outline-success btn-sm rounded-pill"
        onclick="return confirm('Restore this backup? This will overwrite the current database.')">
        Restore
    </button>
</form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                No backups yet. Click "Backup Now" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection