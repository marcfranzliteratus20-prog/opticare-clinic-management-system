@extends(
    session('user_role') == 'Staff'
        ? 'layouts.staff'
        : 'layouts.app'
)

@section('content')
<div class="card shadow-sm rounded-4">
    <div class="card-header bg-primary text-white">
        <h3>Search Results for "{{ $search }}"</h3>
    </div>

    <div class="card-body">

        <h5>Patients</h5>
        <ul>
            @forelse($patients as $patient)
                <li>
                    <a href="{{ route('patients.edit', $patient->id) }}">
                        {{ $patient->full_name }}
                    </a>
                </li>
            @empty
                <li>No patient found</li>
            @endforelse
        </ul>

        <h5>Inventory</h5>
        <ul>
            @forelse($inventories as $item)
                <li>
                    <a href="{{ route('inventory.edit', $item->id) }}">
                        {{ $item->product_name }}
                    </a>
                </li>
            @empty
                <li>No product found</li>
            @endforelse
        </ul>

        <h5>Billing</h5>
        <ul>
            @forelse($billings as $bill)
                <li>
                    <a href="{{ route('billing.edit', $bill->id) }}">
                        {{ $bill->service_type }} -- {{ $bill->patient->full_name ?? 'Unknown patient' }}
                    </a>
                </li>
            @empty
                <li>No billing found</li>
            @endforelse
        </ul>

        <h5>Appointments</h5>
        <ul>
            @forelse($appointments as $appointment)
                <li>
                    <a href="{{ route('appointments.edit', $appointment->id) }}">
                        {{ $appointment->doctor_name }} -- {{ $appointment->patient->full_name ?? 'Unknown patient' }}
                    </a>
                </li>
            @empty
                <li>No appointment found</li>
            @endforelse
        </ul>

        <div class="mb-3">
            {{-- FIX: 'dashboard' needs quotes and no space -- route(dashboard)
                 without quotes is a fatal error (undefined constant).
                 Also routes back to the correct dashboard per role. --}}
            <a href="{{ route(session('user_role') == 'Staff' ? 'staff.dashboard' : 'dashboard') }}"
               class="btn btn-secondary rounded-pill">
                ← Back
            </a>
        </div>
    </div>
</div>
@endsection