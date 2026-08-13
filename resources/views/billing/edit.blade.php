@extends(
    session('user_role') == 'Staff'
        ? 'layouts.staff'
        : 'layouts.app'
)

@section('content')
<div class="oc-page">

    <div class="mb-4">
        <p class="oc-eyebrow">Payments &amp; Records</p>
        <h2 class="oc-heading">Edit Billing</h2>
    </div>

    <div class="oc-card" style="max-width: 640px;">
        <div class="oc-card-body">

            @if($errors->any())
                <div class="oc-alert oc-alert-danger">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('billing.update', $billing->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="oc-field">
                    <label>Patient</label>
                    <select name="patient_id" required>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}"
                                {{ old('patient_id', $billing->patient_id) == $patient->id ? 'selected' : '' }}>
                                {{ $patient->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="oc-field">
                    <label>Amount</label>
                    <input type="number" step="0.01" name="amount" min="0"
                           value="{{ old('amount', $billing->amount) }}" required>
                </div>

                <div class="oc-field">
                    <label>Service Type</label>
                    <select name="service_type" required>
                        @php
                            $services = [
                                'Comprehensive Eye Examination',
                                'Prescription Eyeglasses',
                                'Contact Lens Fitting and Assessment',
                                'Ishihara Color Vision Test',
                                'Eye Condition Certification',
                                'Eyewear Accessories',
                                'Eyewear Repair and Maintenance',
                                'Frame Fitting',
                                'Other'
                            ];
                        @endphp
                        @foreach($services as $service)
                            <option value="{{ $service }}" 
                                {{ old('service_type', $billing->service_type) == $service ? 'selected' : '' }}>
                                {{ $service }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="oc-field">
                    <label>
                        Warranty <span class="oc-optional">(months, optional — for eyewear purchases)</span>
                    </label>
                    <input type="number" name="warranty_months" min="0" max="60"
                           value="{{ old('warranty_months', $billing->warranty_months) }}">
                    @if($billing->warranty_expiry)
                        <small class="oc-optional d-block mt-1">
                            Current coverage until {{ \Carbon\Carbon::parse($billing->warranty_expiry)->format('M d, Y') }}
                        </small>
                    @endif
                </div>

                <div class="oc-field">
                    <label>Payment Status</label>
                    <select name="payment_status" required>
                        @foreach(['Unpaid', 'Paid', 'Partial'] as $status)
                            <option value="{{ $status }}" 
                                {{ old('payment_status', $billing->payment_status) == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="oc-btn oc-btn-primary">Update Billing</button>
                    <a href="{{ route('billing.index') }}" class="oc-btn oc-btn-ghost-bordered">Cancel</a>
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