@extends(
    session('user_role') == 'Staff'
        ? 'layouts.staff'
        : 'layouts.app'
)

@section('content')
<div class="oc-page">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <p class="oc-eyebrow">Clinic Records</p>
            <h2 class="oc-heading">Patients</h2>
        </div>

        <a href="{{ route('patients.create') }}" class="oc-btn oc-btn-primary">
            <i class="bi bi-plus-lg"></i> Add Patient
        </a>
    </div>

    <div class="oc-card mb-4">
        <div class="oc-card-body">
            <form method="GET" action="{{ route('patients.index') }}" class="oc-search-form">
                <i class="bi bi-search"></i>
                <input type="text" name="search"
                       placeholder="Search patient name or contact number..."
                       value="{{ request('search') }}">
                <button type="submit" class="oc-btn oc-btn-outline">Search</button>
                @if(request('search'))
                    <a href="{{ route('patients.index') }}" class="oc-btn oc-btn-ghost">Clear</a>
                @endif
            </form>
        </div>
    </div>

    <div class="oc-card">
        <div class="table-responsive">
            <table class="oc-table">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Eye Grade</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td class="fw-semibold">{{ $patient->full_name }}</td>
                            <td>{{ $patient->age }}</td>
                            <td>{{ $patient->gender }}</td>
                            <td>{{ $patient->contact_number }}</td>
                            <td style="max-width: 220px;" class="text-truncate">{{ $patient->address }}</td>
                            <td>{{ $patient->eye_grade ?? '—' }}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    <a href="{{ route('patients.edit', $patient->id) }}" class="oc-btn oc-btn-sm oc-btn-outline">
                                        Edit
                                    </a>
                                    <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="oc-btn oc-btn-sm oc-btn-terracotta"
                                                onclick="return confirm('Delete this patient?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 oc-muted">
                                @if(request('search'))
                                    No patients match "{{ request('search') }}".
                                @else
                                    No patients found.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="oc-card-body">
            <div class="d-flex justify-content-center">
                {{ $patients->appends(['search' => request('search')])->links() }}
            </div>
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
        --oc-terracotta: #C1533A;
        font-family: 'Inter', 'Segoe UI', sans-serif;
        color: var(--oc-ink);
    }

    .oc-eyebrow {
        text-transform: uppercase;
        letter-spacing: 0.12em;
        font-size: 0.7rem;
        font-weight: 600;
        color: var(--oc-gold);
        margin-bottom: 4px;
    }

    .oc-heading { font-family: 'Fraunces', Georgia, serif; font-weight: 600; margin-bottom: 0; }
    .oc-muted { color: #9a9a94; }

    .oc-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid rgba(28, 43, 51, 0.06);
        box-shadow: 0 2px 10px rgba(28, 43, 51, 0.04);
    }

    .oc-card-body { padding: 18px 22px; }

    .oc-search-form { display: flex; align-items: center; gap: 10px; }
    .oc-search-form i { color: var(--oc-teal); }

    .oc-search-form input {
        flex: 1;
        border: 1px solid rgba(28,43,51,0.12);
        border-radius: 12px;
        padding: 9px 14px;
        font-size: 0.9rem;
        outline: none;
    }

    .oc-search-form input:focus { border-color: var(--oc-teal); }

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

    .oc-table tbody tr:hover { background: var(--oc-teal-light); }

    .oc-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 20px;
        padding: 9px 18px;
        font-size: 0.88rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .oc-btn-sm { padding: 6px 13px; font-size: 0.78rem; }

    .oc-btn-primary { background: var(--oc-teal); color: #fff; }
    .oc-btn-primary:hover { background: #123638; color: #fff; }

    .oc-btn-outline { background: transparent; color: var(--oc-teal); border: 1px solid rgba(27,75,79,0.25); }
    .oc-btn-outline:hover { background: var(--oc-teal-light); color: var(--oc-teal); }

    .oc-btn-ghost { background: transparent; color: #8a8a85; }
    .oc-btn-ghost:hover { color: var(--oc-ink); }

    .oc-btn-terracotta { background: transparent; color: var(--oc-terracotta); border: 1px solid rgba(193,83,58,0.3); }
    .oc-btn-terracotta:hover { background: rgba(193,83,58,0.08); color: var(--oc-terracotta); }

    .page-link { color: var(--oc-teal); }
    .page-item.active .page-link { background: var(--oc-teal); border-color: var(--oc-teal); }
</style>
@endsection