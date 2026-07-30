@extends(
    session('user_role') == 'Staff'
        ? 'layouts.staff'
        : 'layouts.app'
)

@section('content')
<div class="oc-page">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <p class="oc-eyebrow">Payments &amp; Records</p>
            <h2 class="oc-heading">Billing</h2>
        </div>

        <a href="{{ route('billing.create') }}" class="oc-btn oc-btn-primary">
            <i class="bi bi-plus-lg"></i> Add Billing
        </a>
    </div>

    <div class="oc-card mb-4">
        <div class="oc-card-body">
            <form method="GET" action="{{ route('billing.index') }}" class="oc-search-form">
                <i class="bi bi-search"></i>
                <input type="text" name="search"
                       placeholder="Search by patient, service, or status..."
                       value="{{ $search ?? '' }}">
                <button type="submit" class="oc-btn oc-btn-outline">Search</button>
                @if(!empty($search))
                    <a href="{{ route('billing.index') }}" class="oc-btn oc-btn-ghost">Clear</a>
                @endif
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="oc-alert oc-alert-success mb-3">{{ session('success') }}</div>
    @endif

    <div class="oc-card">
        <div class="table-responsive">
            <table class="oc-table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Amount</th>
                        <th>Service</th>
                        <th>Warranty</th>
                        <th>Status</th>
                        <th width="240">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($billings as $bill)
                        <tr>
                            <td class="fw-semibold">{{ $bill->patient->full_name ?? 'Unknown patient' }}</td>
                            <td>₱{{ number_format($bill->amount, 2) }}</td>
                            <td>{{ $bill->service_type }}</td>
                            <td>
                                @if(!$bill->warranty_expiry)
                                    <span class="oc-muted">—</span>
                                @elseif($bill->warranty_expiry->isPast())
                                    <span class="oc-badge oc-badge-terracotta">Expired {{ $bill->warranty_expiry->format('M d, Y') }}</span>
                                @else
                                    <span class="oc-badge oc-badge-sage">Until {{ $bill->warranty_expiry->format('M d, Y') }}</span>
                                @endif
                            </td>
                            <td>
                                @if($bill->payment_status == 'Paid')
                                    <span class="oc-badge oc-badge-sage">Paid</span>
                                @else
                                    <span class="oc-badge oc-badge-terracotta">Unpaid</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    <a href="{{ route('billing.edit', $bill->id) }}" class="oc-btn oc-btn-sm oc-btn-outline">
                                        Edit
                                    </a>

                                    @if($bill->payment_status == 'Unpaid')
                                        <form action="{{ route('billing.paid', $bill->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button class="oc-btn oc-btn-sm oc-btn-sage">Mark Paid</button>
                                        </form>
                                    @else
                                        <a href="{{ route('billing.receipt', $bill->id) }}" target="_blank" class="oc-btn oc-btn-sm oc-btn-outline">
                                            <i class="bi bi-receipt"></i> Receipt
                                        </a>
                                    @endif

                                    <form action="{{ route('billing.destroy', $bill->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="oc-btn oc-btn-sm oc-btn-terracotta"
                                                onclick="return confirm('Delete this billing record?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 oc-muted">
                                @if(!empty($search))
                                    No billing records match "{{ $search }}".
                                @else
                                    No billing records found.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="oc-card-body">
            <div class="d-flex justify-content-center">
                {{ $billings->appends(['search' => $search ?? null])->links() }}
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

    .oc-heading {
        font-family: 'Fraunces', Georgia, serif;
        font-weight: 600;
        margin-bottom: 0;
    }

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

    .oc-search-form {
        display: flex;
        align-items: center;
        gap: 10px;
    }

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

    .oc-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .oc-badge-sage { background: rgba(63,125,92,0.15); color: var(--oc-sage); }
    .oc-badge-terracotta { background: rgba(193,83,58,0.15); color: var(--oc-terracotta); }

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

    .oc-btn-sage { background: var(--oc-sage); color: #fff; }
    .oc-btn-sage:hover { background: #356a4d; color: #fff; }

    .oc-btn-terracotta { background: transparent; color: var(--oc-terracotta); border: 1px solid rgba(193,83,58,0.3); }
    .oc-btn-terracotta:hover { background: rgba(193,83,58,0.08); color: var(--oc-terracotta); }

    .page-link { color: var(--oc-teal); }
    .page-item.active .page-link { background: var(--oc-teal); border-color: var(--oc-teal); }
</style>
@endsection