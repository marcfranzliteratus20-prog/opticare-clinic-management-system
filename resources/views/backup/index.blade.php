@extends('layouts.app')

@section('content')
<div class="oc-page">

    <div class="oc-header">
        <div>
            <p class="oc-eyebrow">Utilities</p>
            <h2 class="oc-heading"><i class="bi bi-hdd-stack"></i> Database Backup</h2>
            <p class="oc-subtitle">Create and manage downloadable backups of the clinic database.</p>
        </div>

        <div class="oc-toolbar">
            <form action="{{ route('backup.create') }}" method="POST">
                @csrf
                <button class="oc-btn oc-btn-primary">
                    <i class="bi bi-hdd-stack"></i> Backup Now
                </button>
            </form>

            <a href="{{ route('backup.restore.form') }}" class="oc-btn oc-btn-sage">
                <i class="bi bi-arrow-counterclockwise"></i> Restore Database
            </a>

            <a href="{{ route('backup.schedule') }}" class="oc-btn oc-btn-gold">
                <i class="bi bi-clock-history"></i> Automatic Backup
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="oc-alert oc-alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="oc-alert oc-alert-danger">{{ session('error') }}</div>
    @endif

    <div class="oc-card">
        <div class="table-responsive">
            <table class="oc-table">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th>Size</th>
                        <th>Date Created</th>
                        <th width="300">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($backups as $backup)
                        <tr>
                            <td class="fw-semibold">{{ $backup['name'] }}</td>
                            <td>{{ $backup['size'] }} KB</td>
                            <td>{{ \Carbon\Carbon::createFromTimestamp($backup['date'])->format('M d, Y g:i A') }}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    <a href="{{ route('backup.download', $backup['name']) }}" class="oc-btn oc-btn-sm oc-btn-outline">
                                        Download
                                    </a>

                                    <form action="{{ route('backup.restore', $backup['name']) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="oc-btn oc-btn-sm oc-btn-sage-outline"
                                                onclick="return confirm('Restore this backup? This will overwrite the current database.')">
                                            Restore
                                        </button>
                                    </form>

                                    <form action="{{ route('backup.destroy', $backup['name']) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="oc-btn oc-btn-sm oc-btn-terracotta"
                                                onclick="return confirm('Delete backup?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 oc-muted">
                                No backups yet. Click <strong>Backup Now</strong> to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=fraunces:500,600,700|inter:400,500,600,700" rel="stylesheet" />

<style>
    .oc-page {
        --oc-ink: #1C2B33;
        --oc-teal: #1B4B4F;
        --oc-teal-light: #E8F0EF;
        --oc-gold: #C98A3E;
        --oc-amber-dark: #A8672A;
        --oc-sage: #3F7D5C;
        --oc-terracotta: #C1533A;
        font-family: 'Inter', 'Segoe UI', sans-serif !important;
        color: var(--oc-ink);
    }

    .oc-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }

    .oc-eyebrow {
        text-transform: uppercase;
        letter-spacing: 0.12em;
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--oc-gold);
        margin-bottom: 4px;
    }

    .oc-heading {
        font-family: 'Fraunces', Georgia, serif !important;
        font-weight: 600;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .oc-subtitle { color: #7a8a8e; font-size: 0.9rem; margin-bottom: 0; }
    .oc-muted { color: #9a9a94; }

    /* Toolbar -- explicit rules so buttons never collapse into circles,
       regardless of whatever global .btn styles exist elsewhere in the app. */
    .oc-toolbar {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
    }

    .oc-btn {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border-radius: 24px !important;
        padding: 10px 20px !important;
        font-size: 0.88rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        white-space: nowrap;
        width: auto !important;
        height: auto !important;
        min-width: max-content;
        line-height: 1.3;
    }

    .oc-btn-sm { padding: 7px 14px !important; font-size: 0.78rem; }

    .oc-btn-primary { background: var(--oc-teal); color: #fff; }
    .oc-btn-primary:hover { background: #123638; color: #fff; }

    .oc-btn-sage { background: var(--oc-sage); color: #fff; }
    .oc-btn-sage:hover { background: #356a4d; color: #fff; }

    .oc-btn-gold { background: var(--oc-gold); color: #fff; }
    .oc-btn-gold:hover { background: #b57834; color: #fff; }

    .oc-btn-outline { background: transparent; color: var(--oc-teal); border: 1px solid rgba(27,75,79,0.25) !important; }
    .oc-btn-outline:hover { background: var(--oc-teal-light); color: var(--oc-teal); }

    .oc-btn-sage-outline { background: transparent; color: var(--oc-sage); border: 1px solid rgba(63,125,92,0.3) !important; }
    .oc-btn-sage-outline:hover { background: rgba(63,125,92,0.08); color: var(--oc-sage); }

    .oc-btn-terracotta { background: transparent; color: var(--oc-terracotta); border: 1px solid rgba(193,83,58,0.3) !important; }
    .oc-btn-terracotta:hover { background: rgba(193,83,58,0.08); color: var(--oc-terracotta); }

    .oc-alert { border-radius: 12px; padding: 12px 18px; font-size: 0.88rem; margin-bottom: 16px; }
    .oc-alert-success { background: rgba(63,125,92,0.1); color: var(--oc-sage); }
    .oc-alert-danger { background: rgba(193,83,58,0.1); color: var(--oc-terracotta); }

    .oc-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid rgba(28, 43, 51, 0.06);
        box-shadow: 0 2px 10px rgba(28, 43, 51, 0.04);
    }

    .oc-table { width: 100%; border-collapse: collapse; }

    .oc-table thead th {
        text-align: left;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        font-size: 0.7rem;
        font-weight: 600;
        color: #8a8a85;
        padding: 14px 22px;
        border-bottom: 1px solid rgba(28,43,51,0.06);
    }

    .oc-table tbody td {
        padding: 14px 22px;
        border-bottom: 1px solid rgba(28,43,51,0.05);
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .oc-table tbody tr:last-child td { border-bottom: none; }
    .oc-table tbody tr:hover { background: var(--oc-teal-light); }

    @media (max-width: 640px) {
        .oc-toolbar { width: 100%; }
        .oc-toolbar form, .oc-toolbar a { flex: 1; }
        .oc-btn { width: 100% !important; }
    }
</style>
@endsection