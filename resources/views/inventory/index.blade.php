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
            <h2 class="oc-heading">Inventory</h2>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('inventory.history') }}" class="oc-btn oc-btn-outline">
                <i class="bi bi-clock-history"></i> Stock History
            </a>
            <a href="{{ route('inventory.export') }}" class="oc-btn oc-btn-outline">
                <i class="bi bi-download"></i> Export CSV
            </a>
            @if(session('user_role') == 'Admin')
                <a href="{{ route('inventory.create') }}" class="oc-btn oc-btn-primary">
                    <i class="bi bi-plus-lg"></i> Add Product
                </a>
            @endif
        </div>
    </div>

    <div class="oc-card mb-4">
        <div class="oc-card-body">
            <form method="GET" action="{{ route('inventory.index') }}" class="oc-search-form">
                <i class="bi bi-search"></i>
                <input type="text" name="search" placeholder="Search by name or SKU..." value="{{ request('search') }}">

                <select name="category" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="oc-btn oc-btn-outline">Search</button>
                @if(request('search') || request('category'))
                    <a href="{{ route('inventory.index') }}" class="oc-btn oc-btn-ghost">Clear</a>
                @endif
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="oc-alert oc-alert-success mb-3">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="oc-alert oc-alert-danger mb-3">
            <strong>Please fix the following before saving:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="oc-card">
        <div class="table-responsive">
            <table class="oc-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Expiry</th>
                        <th>Price</th>
                        <th width="260">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inventories as $item)
                        <tr>
                            <td>
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->product_name }}" class="oc-thumb">
                                @else
                                    <div class="oc-thumb oc-thumb-placeholder"><i class="bi bi-image"></i></div>
                                @endif
                            </td>
                            <td>
                                <span class="fw-semibold d-block">{{ $item->product_name }}</span>
                                @if($item->sku)
                                    <span class="oc-muted" style="font-size: 0.76rem;">SKU: {{ $item->sku }}</span>
                                @endif
                            </td>
                            <td>{{ $item->category }}</td>
                            <td>
                                @if($item->quantity <= $item->reorder_level)
                                    <span class="oc-badge oc-badge-terracotta">Low ({{ $item->quantity }} {{ $item->unit ?? 'pcs' }})</span>
                                @elseif($item->quantity <= $item->reorder_level * 2)
                                    <span class="oc-badge oc-badge-gold">{{ $item->quantity }} {{ $item->unit ?? 'pcs' }}</span>
                                @else
                                    <span class="oc-badge oc-badge-sage">{{ $item->quantity }} {{ $item->unit ?? 'pcs' }}</span>
                                @endif
                            </td>
                            <td>
                                @if(!$item->expiry_date)
                                    <span class="oc-muted">—</span>
                                @elseif($item->expiry_date->isPast())
                                    <span class="oc-badge oc-badge-terracotta">Expired {{ $item->expiry_date->format('M d, Y') }}</span>
                                @elseif($item->expiry_date->diffInDays(now()) <= 30)
                                    <span class="oc-badge oc-badge-gold">Expiring {{ $item->expiry_date->format('M d, Y') }}</span>
                                @else
                                    {{ $item->expiry_date->format('M d, Y') }}
                                @endif
                            </td>
                            <td>₱{{ number_format($item->price, 2) }}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    <button type="button" class="oc-btn oc-btn-sm oc-btn-sage adjust-btn"
                                            data-id="{{ $item->id }}"
                                            data-name="{{ $item->product_name }}"
                                            data-quantity="{{ $item->quantity }}"
                                            data-unit="{{ $item->unit ?? 'pcs' }}">
                                        <i class="bi bi-arrow-down-up"></i> Adjust
                                    </button>

                                    <a href="{{ route('inventory.history', ['inventory_id' => $item->id]) }}" class="oc-btn oc-btn-sm oc-btn-outline">
                                        History
                                    </a>

                                    @if(session('user_role') == 'Admin')
                                        <a href="{{ route('inventory.edit', $item->id) }}" class="oc-btn oc-btn-sm oc-btn-outline">
                                            Edit
                                        </a>
                                        <form action="{{ route('inventory.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="oc-btn oc-btn-sm oc-btn-terracotta">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 oc-muted">
                                @if(request('search') || request('category'))
                                    No products match your filters.
                                @else
                                    No products found.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="oc-card-body">
            <div class="d-flex justify-content-center">
                {{ $inventories->appends(['search' => request('search'), 'category' => request('category')])->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Quick Stock Adjust Modal -->
<div class="modal fade" id="adjustModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 18px; border: none;">
            <form id="adjustForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header border-0">
                    <h5 class="modal-title oc-heading" id="adjustModalLabel">Adjust Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="oc-muted mb-3">
                        Current stock: <strong id="adjustCurrentQty">0</strong> <span id="adjustUnit"></span>
                    </p>

                    <div class="oc-field">
                        <label>Direction</label>
                        <select name="direction" required>
                            <option value="in">Stock In (add)</option>
                            <option value="out">Stock Out (remove)</option>
                        </select>
                    </div>

                    <div class="oc-field">
                        <label>Amount</label>
                        <input type="number" name="amount" min="1" required>
                    </div>

                    <div class="oc-field">
                        <label>Reason</label>
                        <select name="reason" required>
                            <option value="Restock">Restock (new delivery)</option>
                            <option value="Sold">Sold</option>
                            <option value="Damaged/Expired">Damaged / Expired</option>
                            <option value="Correction">Inventory Correction</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="oc-btn oc-btn-ghost-bordered" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="oc-btn oc-btn-primary">Save Adjustment</button>
                </div>
            </form>
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

    .oc-search-form select {
        border: 1px solid rgba(28,43,51,0.12);
        border-radius: 12px;
        padding: 9px 14px;
        font-size: 0.9rem;
        outline: none;
        background: #fff;
        color: var(--oc-ink);
        min-width: 160px;
    }

    .oc-search-form select:focus { border-color: var(--oc-teal); }
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
        padding: 12px 22px;
        border-bottom: 1px solid rgba(28,43,51,0.05);
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .oc-table tbody tr:hover { background: var(--oc-teal-light); }

    .oc-thumb {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        object-fit: cover;
        display: block;
    }

    .oc-thumb-placeholder {
        background: #f2f2ef;
        color: #c7c7c0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
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

    .oc-btn-ghost-bordered { background: transparent; color: #5a6b70; border: 1px solid rgba(28,43,51,0.14); }

    .oc-btn-sage { background: var(--oc-sage); color: #fff; }
    .oc-btn-sage:hover { background: #356a4d; color: #fff; }

    .oc-btn-terracotta { background: transparent; color: var(--oc-terracotta); border: 1px solid rgba(193,83,58,0.3); }
    .oc-btn-terracotta:hover { background: rgba(193,83,58,0.08); color: var(--oc-terracotta); }

    .oc-field { margin-bottom: 16px; }
    .oc-field label { display: block; font-size: 0.8rem; font-weight: 600; color: #5a6b70; margin-bottom: 6px; }
    .oc-optional { font-weight: 400; color: #a0a09a; }
    .oc-field input, .oc-field select {
        width: 100%;
        border: 1px solid rgba(28,43,51,0.14);
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 0.92rem;
        outline: none;
    }
    .oc-field input:focus, .oc-field select:focus { border-color: var(--oc-teal); }

    #adjustModal .modal-content {
        border-radius: 18px !important;
        border: 1px solid rgba(255, 255, 255, 0.5) !important;
        background: rgba(255, 255, 255, 0.35) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 20px 60px rgba(28, 43, 51, 0.3);
    }

    #adjustModal .modal-content label,
    #adjustModal .modal-content .oc-muted,
    #adjustModal .modal-content h5 {
        text-shadow: 0 1px 2px rgba(255,255,255,0.6);
    }

    #adjustModal .modal-content .oc-field input,
    #adjustModal .modal-content .oc-field select {
        background: rgba(255, 255, 255, 0.55);
    }

    .modal-backdrop.show {
        opacity: 0.15;
    }
</style>

<script>
    function openAdjustModal(id, name, quantity, unit) {
        document.getElementById('adjustModalLabel').innerText = 'Adjust Stock — ' + name;
        document.getElementById('adjustCurrentQty').innerText = quantity;
        document.getElementById('adjustUnit').innerText = unit;
        document.getElementById('adjustForm').action = '/inventory/' + id + '/adjust';

        const modal = new bootstrap.Modal(document.getElementById('adjustModal'));
        modal.show();
    }

    document.querySelectorAll('.adjust-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            openAdjustModal(
                btn.dataset.id,
                btn.dataset.name,
                btn.dataset.quantity,
                btn.dataset.unit
            );
        });
    });
</script>
@endsection