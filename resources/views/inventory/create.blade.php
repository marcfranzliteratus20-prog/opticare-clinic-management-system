@extends(
    session('user_role') == 'Staff'
        ? 'layouts.staff'
        : 'layouts.app'
)

@section('content')
<div class="oc-page">

    <div class="mb-4">
        <p class="oc-eyebrow">Frames, Lenses &amp; Stock</p>
        <h2 class="oc-heading">Add Product</h2>
    </div>

    <div class="oc-card" style="max-width: 640px;">
        <div class="oc-card-body">

            @if($errors->any())
                <div class="oc-alert oc-alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="oc-field">
                    <label>Product Name</label>
                    <input type="text" name="product_name" value="{{ old('product_name') }}" required>
                </div>

                <div class="oc-field">
                    <label>SKU / Barcode <span class="oc-optional">(optional)</span></label>
                    <input type="text" name="sku" value="{{ old('sku') }}" placeholder="e.g. FR-0012">
                </div>

                <div class="oc-field">
                    <label>Category</label>
                    <input type="text" name="category" value="{{ old('category') }}" required>
                </div>

                <div class="row g-2">
                    <div class="col-8">
                        <div class="oc-field">
                            <label>Stock Quantity</label>
                            <input type="number" name="quantity" min="0" value="{{ old('quantity') }}" required>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="oc-field">
                            <label>Unit</label>
                            <select name="unit">
                                <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>pcs</option>
                                <option value="pairs" {{ old('unit') == 'pairs' ? 'selected' : '' }}>pairs</option>
                                <option value="boxes" {{ old('unit') == 'boxes' ? 'selected' : '' }}>boxes</option>
                                <option value="bottles" {{ old('unit') == 'bottles' ? 'selected' : '' }}>bottles</option>
                                <option value="sets" {{ old('unit') == 'sets' ? 'selected' : '' }}>sets</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="oc-field">
                    <label>
                        Reorder Level
                        <span class="oc-optional">(alert when stock falls to or below this)</span>
                    </label>
                    <input type="number" name="reorder_level" min="0" value="{{ old('reorder_level', 5) }}">
                </div>

                <div class="oc-field">
                    <label>Expiry Date <span class="oc-optional">(optional, for solutions/disposables)</span></label>
                    <input type="date" name="expiry_date" value="{{ old('expiry_date') }}">
                </div>

                <div class="oc-field">
                    <label>Supplier <span class="oc-optional">(optional)</span></label>
                    <input type="text" name="supplier" value="{{ old('supplier') }}">
                </div>

                <div class="oc-field">
                    <label>Price</label>
                    <input type="number" step="0.01" name="price" min="0" value="{{ old('price') }}" required>
                </div>

                <div class="oc-field">
                    <label>Product Image <span class="oc-optional">(optional, max 2MB)</span></label>
                    <input type="file" name="image" accept="image/*">
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="oc-btn oc-btn-primary">Save Product</button>
                    <a href="{{ route('inventory.index') }}" class="oc-btn oc-btn-ghost-bordered">Cancel</a>
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

    .oc-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid rgba(28, 43, 51, 0.06);
        box-shadow: 0 2px 10px rgba(28, 43, 51, 0.04);
    }

    .oc-card-body { padding: 28px; }

    .oc-field { margin-bottom: 18px; }

    .oc-field label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #5a6b70;
        margin-bottom: 6px;
    }

    .oc-optional { font-weight: 400; color: #a0a09a; }

    .oc-field input, .oc-field select {
        width: 100%;
        border: 1px solid rgba(28,43,51,0.14);
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 0.92rem;
        font-family: 'Inter', sans-serif;
        color: var(--oc-ink);
        outline: none;
    }

    .oc-field input:focus, .oc-field select:focus { border-color: var(--oc-teal); }

    .oc-alert { border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; font-size: 0.88rem; }
    .oc-alert-danger { background: rgba(193,83,58,0.1); color: var(--oc-terracotta); }

    .oc-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 20px;
        padding: 10px 22px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .oc-btn-primary { background: var(--oc-teal); color: #fff; }
    .oc-btn-primary:hover { background: #123638; color: #fff; }

    .oc-btn-ghost-bordered { background: transparent; color: #5a6b70; border: 1px solid rgba(28,43,51,0.14); }
    .oc-btn-ghost-bordered:hover { background: #f5f5f3; color: var(--oc-ink); }
</style>
@endsection