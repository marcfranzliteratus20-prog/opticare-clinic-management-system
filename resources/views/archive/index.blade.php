@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2 class="fw-bold mb-1">🗄️ Archive</h2>
        <p class="text-muted mb-0">Deleted records are kept here and can be restored or permanently removed.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-3">{{ session('success') }}</div>
    @endif

    <!-- Patients -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 rounded-top-4 pt-3">
            <h5 class="mb-0">Patients <span class="badge bg-secondary">{{ $patients->count() }}</span></h5>
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Contact</th>
                        <th>Deleted At</th>
                        <th width="220">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td>{{ $patient->full_name }}</td>
                            <td>{{ $patient->contact_number }}</td>
                            <td>{{ $patient->deleted_at->format('M d, Y g:i A') }}</td>
                            <td>
                                <form action="{{ route('archive.restore', ['type' => 'patients', 'id' => $patient->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-success btn-sm rounded-pill">Restore</button>
                                </form>
                                <form action="{{ route('archive.force', ['type' => 'patients', 'id' => $patient->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm rounded-pill"
                                            onclick="return confirm('Permanently delete this patient? This cannot be undone.')">
                                        Delete Permanently
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted">No archived patients.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Appointments -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 rounded-top-4 pt-3">
            <h5 class="mb-0">Appointments <span class="badge bg-secondary">{{ $appointments->count() }}</span></h5>
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Date</th>
                        <th>Doctor</th>
                        <th>Deleted At</th>
                        <th width="220">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->patient->full_name ?? 'Unknown patient' }}</td>
                            <td>{{ $appointment->appointment_date }}</td>
                            <td>{{ $appointment->doctor_name }}</td>
                            <td>{{ $appointment->deleted_at->format('M d, Y g:i A') }}</td>
                            <td>
                                <form action="{{ route('archive.restore', ['type' => 'appointments', 'id' => $appointment->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-success btn-sm rounded-pill">Restore</button>
                                </form>
                                <form action="{{ route('archive.force', ['type' => 'appointments', 'id' => $appointment->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm rounded-pill"
                                            onclick="return confirm('Permanently delete this appointment? This cannot be undone.')">
                                        Delete Permanently
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">No archived appointments.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Billing -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 rounded-top-4 pt-3">
            <h5 class="mb-0">Billing <span class="badge bg-secondary">{{ $billings->count() }}</span></h5>
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Amount</th>
                        <th>Service</th>
                        <th>Deleted At</th>
                        <th width="220">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($billings as $bill)
                        <tr>
                            <td>{{ $bill->patient->full_name ?? 'Unknown patient' }}</td>
                            <td>₱{{ number_format($bill->amount, 2) }}</td>
                            <td>{{ $bill->service_type }}</td>
                            <td>{{ $bill->deleted_at->format('M d, Y g:i A') }}</td>
                            <td>
                                <form action="{{ route('archive.restore', ['type' => 'billings', 'id' => $bill->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-success btn-sm rounded-pill">Restore</button>
                                </form>
                                <form action="{{ route('archive.force', ['type' => 'billings', 'id' => $bill->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm rounded-pill"
                                            onclick="return confirm('Permanently delete this billing record? This cannot be undone.')">
                                        Delete Permanently
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">No archived billing records.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Inventory -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 rounded-top-4 pt-3">
            <h5 class="mb-0">Inventory <span class="badge bg-secondary">{{ $inventory->count() }}</span></h5>
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th></th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Deleted At</th>
                        <th width="220">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inventory as $item)
                        <tr>
                            <td>
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->product_name }}"
                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                                @else
                                    <i class="bi bi-image text-muted"></i>
                                @endif
                            </td>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->category }}</td>
                            <td>{{ $item->deleted_at->format('M d, Y g:i A') }}</td>
                            <td>
                                <form action="{{ route('archive.restore', ['type' => 'inventory', 'id' => $item->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-success btn-sm rounded-pill">Restore</button>
                                </form>
                                <form action="{{ route('archive.force', ['type' => 'inventory', 'id' => $item->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm rounded-pill"
                                            onclick="return confirm('Permanently delete this product and its image? This cannot be undone.')">
                                        Delete Permanently
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">No archived products.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection