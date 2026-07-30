@extends('layouts.app')

@section('content')
<div class="oc-page">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <p class="oc-eyebrow">Access &amp; Accounts</p>
            <h2 class="oc-heading">User Management</h2>
        </div>

        <a href="{{ route('users.create') }}" class="oc-btn oc-btn-primary">
            <i class="bi bi-person-plus"></i> Add User
        </a>
    </div>

    <div class="oc-card mb-4">
        <div class="oc-card-body">
            <form method="GET" action="{{ route('users.index') }}" class="oc-search-form">
                <i class="bi bi-search"></i>
                <input type="text" name="search" placeholder="Search by name or email..." value="{{ $search ?? '' }}">
                <button type="submit" class="oc-btn oc-btn-outline">Search</button>
                @if(!empty($search))
                    <a href="{{ route('users.index') }}" class="oc-btn oc-btn-ghost">Clear</a>
                @endif
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="oc-alert oc-alert-success mb-3">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="oc-alert oc-alert-danger mb-3">{{ session('error') }}</div>
    @endif

    <div class="oc-card">
        <div class="table-responsive">
            <table class="oc-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="oc-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                    <span class="fw-semibold">{{ $user->name }}</span>
                                    @if(session('user') === $user->id)
                                        <span class="oc-badge oc-badge-neutral">You</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role == 'Admin')
                                    <span class="oc-badge oc-badge-gold">Admin</span>
                                @else
                                    <span class="oc-badge oc-badge-sage">Staff</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    <a href="{{ route('users.edit', $user->id) }}" class="oc-btn oc-btn-sm oc-btn-outline">
                                        Edit
                                    </a>

                                    @if(session('user') !== $user->id)
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="oc-btn oc-btn-sm oc-btn-terracotta"
                                                    onclick="return confirm('Delete this user account?')">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 oc-muted">
                                @if(!empty($search))
                                    No users match "{{ $search }}".
                                @else
                                    No users found.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="oc-card-body">
            <div class="d-flex justify-content-center">
                {{ $users->appends(['search' => $search ?? null])->links() }}
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
        --oc-amber-dark: #A8672A;
        --oc-sage: #3F7D5C;
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

    .oc-alert { border-radius: 12px; padding: 12px 18px; font-size: 0.88rem; }
    .oc-alert-success { background: rgba(63,125,92,0.1); color: var(--oc-sage); }
    .oc-alert-danger { background: rgba(193,83,58,0.1); color: var(--oc-terracotta); }

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

    .oc-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--oc-teal-light);
        color: var(--oc-teal);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .oc-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .oc-badge-gold { background: rgba(201,138,62,0.15); color: var(--oc-amber-dark); }
    .oc-badge-sage { background: rgba(63,125,92,0.15); color: var(--oc-sage); }
    .oc-badge-neutral { background: #eee; color: #777; }

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