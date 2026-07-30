@extends(
    session('user_role') == 'Staff'
        ? 'layouts.staff'
        : 'layouts.app'
)

@section('content')
<div class="oc-page">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <p class="oc-eyebrow">Frames, Lenses &amp; Stock</p>
            <h2 class="oc-heading">
                Stock History
                @if($product)
                    <span class="oc-muted" style="font-size: 1.1rem; font-weight: 400;">— {{ $product->product_name }}</span>
                @endif
            </h2>
        </div>

        <div class="d-flex gap-2">
            @if($product)
                <a href="{{ route('inventory.history') }}" class="oc-btn oc-btn-ghost">View All Products</a>
            @endif
            <a href="{{ route('inventory.index') }}" class="oc-btn oc-btn-outline">
                <i class="bi bi-arrow-left"></i> Back to Inventory
            </a>
        </div>
    </div>

    <div class="oc-card">
        <div class="table-responsive">
            <table class="oc-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Change</th>
                        <th>Previous → New</th>
                        <th>Reason</th>
                        <th>By</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('M d, Y g:i A') }}</td>
                            <td class="fw-semibold">{{ $log->inventory->product_name ?? 'Deleted product' }}</td>
                            <td>
                                @if($log->change > 0)
                                    <span class="oc-badge oc-badge-sage">+{{ $log->change }}</span>
                                @else
                                    <span class="oc-badge oc-badge-terracotta">{{ $log->change }}</span>
                                @endif
                            </td>
                            <td>{{ $log->previous_quantity }} → {{ $log->new_quantity }}</td>
                            <td>{{ $log->reason }}</td>
                            <td>{{ $log->user_name ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 oc-muted">No stock movements recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="oc-card-body">
            <div class="d-flex justify-content-center">
                {{ $logs->links() }}
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
        padding: 12px 22px;
        border-bottom: 1px solid rgba(28,43,51,0.05);
        font-size: 0.88rem;
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

    .oc-btn-outline { background: transparent; color: var(--oc-teal); border: 1px solid rgba(27,75,79,0.25); }
    .oc-btn-outline:hover { background: var(--oc-teal-light); color: var(--oc-teal); }

    .oc-btn-ghost { background: transparent; color: #8a8a85; }
    .oc-btn-ghost:hover { color: var(--oc-ink); }

    .page-link { color: var(--oc-teal); }
    .page-item.active .page-link { background: var(--oc-teal); border-color: var(--oc-teal); }
</style>
@endsection