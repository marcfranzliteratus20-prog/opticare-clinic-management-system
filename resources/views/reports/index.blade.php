@extends('layouts.app')

@section('content')
<div class="oc-page">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <p class="oc-eyebrow">Clinic Performance</p>
            <h2 class="oc-heading">Reports</h2>
        </div>

        <a href="{{ route('reports.pdf') }}" class="oc-btn oc-btn-primary">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="oc-card oc-stat" style="--accent: var(--oc-sage);">
                <i class="bi bi-cash-coin oc-stat-icon"></i>
                <span class="oc-stat-label">Total Revenue</span>
                <span class="oc-stat-value">₱{{ number_format($totalRevenue, 0) }}</span>
                <span class="oc-stat-caption">All-time paid billing</span>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="oc-card oc-stat" style="--accent: var(--oc-terracotta);">
                <i class="bi bi-exclamation-circle oc-stat-icon"></i>
                <span class="oc-stat-label">Unpaid Balance</span>
                <span class="oc-stat-value">₱{{ number_format($totalUnpaid, 0) }}</span>
                <span class="oc-stat-caption">Pending collection</span>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="oc-card oc-stat" style="--accent: var(--oc-teal);">
                <i class="bi bi-people oc-stat-icon"></i>
                <span class="oc-stat-label">Total Patients</span>
                <span class="oc-stat-value">{{ $totalPatients }}</span>
                <span class="oc-stat-caption">Registered to date</span>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="oc-card oc-stat" style="--accent: var(--oc-gold);">
                <i class="bi bi-calendar-check oc-stat-icon"></i>
                <span class="oc-stat-label">Appointments</span>
                <span class="oc-stat-value">{{ $totalAppointments }}</span>
                <span class="oc-stat-caption">{{ $completedAppointments }} completed &middot; {{ $cancelledAppointments }} cancelled</span>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row g-3 mb-4">
        <div class="col-lg-6">
            <div class="oc-card">
                <div class="oc-card-header">
                    <i class="bi bi-graph-up-arrow"></i>
                    <h5>Revenue Trend</h5>
                </div>
                <div class="oc-card-body">
                    <canvas id="revenueChart" height="220"
                            data-rows='@json($monthlyRevenue->reverse()->values())'></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="oc-card">
                <div class="oc-card-header">
                    <i class="bi bi-bar-chart"></i>
                    <h5>Most Availed Services</h5>
                </div>
                <div class="oc-card-body">
                    <canvas id="servicesChart" height="220"
                            data-rows='@json($topServices)'></canvas>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="oc-card">
                <div class="oc-card-header">
                    <i class="bi bi-person-lines-fill"></i>
                    <h5>New Patients per Month</h5>
                </div>
                <div class="oc-card-body">
                    <canvas id="patientsChart" height="110"
                            data-rows='@json($monthlyPatients->reverse()->values())'></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Tables -->
    <div class="row g-3">
        <div class="col-lg-6">
            <div class="oc-card">
                <div class="oc-card-header">
                    <i class="bi bi-cash-stack"></i>
                    <h5>Monthly Revenue</h5>
                </div>
                <div class="table-responsive">
                    <table class="oc-table">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th class="text-end">Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($monthlyRevenue as $row)
                                <tr>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $row->month)->format('F Y') }}</td>
                                    <td class="text-end fw-semibold">₱{{ number_format($row->total, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center py-4 oc-muted">No paid billing records yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="oc-card">
                <div class="oc-card-header">
                    <i class="bi bi-star"></i>
                    <h5>Most Availed Services</h5>
                </div>
                <div class="table-responsive">
                    <table class="oc-table">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th class="text-center">Count</th>
                                <th class="text-end">Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topServices as $service)
                                <tr>
                                    <td>{{ $service->service_type }}</td>
                                    <td class="text-center">{{ $service->total }}</td>
                                    <td class="text-end fw-semibold">₱{{ number_format($service->revenue, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 oc-muted">No billing records yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="oc-card">
                <div class="oc-card-header">
                    <i class="bi bi-person-plus"></i>
                    <h5>New Patients per Month</h5>
                </div>
                <div class="table-responsive">
                    <table class="oc-table">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th class="text-end">New Patients</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($monthlyPatients as $row)
                                <tr>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $row->month)->format('F Y') }}</td>
                                    <td class="text-end fw-semibold">{{ $row->total }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center py-4 oc-muted">No patients registered yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
        height: 100%;
    }

    .oc-card-body { padding: 18px 22px; }

    .oc-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 18px 22px 4px;
    }

    .oc-card-header i { color: var(--oc-teal); font-size: 1.1rem; }

    .oc-card-header h5 {
        font-family: 'Fraunces', Georgia, serif;
        font-weight: 600;
        font-size: 1.05rem;
        margin-bottom: 0;
    }

    /* Stat cards */
    .oc-stat {
        padding: 22px;
        display: flex;
        flex-direction: column;
        gap: 4px;
        border-top: 3px solid var(--accent);
    }

    .oc-stat-icon { font-size: 1.1rem; color: var(--accent); margin-bottom: 6px; }

    .oc-stat-label {
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-size: 0.7rem;
        font-weight: 600;
        color: #8a8a85;
    }

    .oc-stat-value {
        font-family: 'Fraunces', serif;
        font-size: 1.9rem;
        font-weight: 600;
        color: var(--oc-ink);
        line-height: 1.15;
    }

    .oc-stat-caption { font-size: 0.76rem; color: #9a9a94; }

    /* Tables */
    .oc-table { width: 100%; border-collapse: collapse; }

    .oc-table thead th {
        text-align: left;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        font-size: 0.68rem;
        font-weight: 600;
        color: #8a8a85;
        padding: 10px 22px;
        border-bottom: 1px solid rgba(28,43,51,0.06);
    }

    .oc-table tbody td {
        padding: 11px 22px;
        border-bottom: 1px solid rgba(28,43,51,0.05);
        font-size: 0.88rem;
        vertical-align: middle;
    }

    .oc-table tbody tr:last-child td { border-bottom: none; }
    .oc-table tbody tr:hover { background: var(--oc-teal-light); }

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

    .oc-btn-primary { background: var(--oc-terracotta); color: #fff; }
    .oc-btn-primary:hover { background: #a5432c; color: #fff; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    // Data is read from data-rows attributes on each canvas (set in the
    // HTML above) instead of being embedded directly in this script
    // block -- keeps Blade syntax out of the JS so editors don't flag it,
    // and it's the pattern Laravel's own docs recommend for passing
    // server data to JS.
    const revenueRows = JSON.parse(document.getElementById('revenueChart').dataset.rows);
    const patientRows = JSON.parse(document.getElementById('patientsChart').dataset.rows);
    const serviceRows = JSON.parse(document.getElementById('servicesChart').dataset.rows);

    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#5a6b70';

    function formatMonth(ym) {
        const [year, month] = ym.split('-');
        const date = new Date(year, month - 1);
        return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
    }

    // Revenue Trend
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: revenueRows.map(r => formatMonth(r.month)),
            datasets: [{
                label: 'Revenue (₱)',
                data: revenueRows.map(r => r.total),
                borderColor: '#1B4B4F',
                backgroundColor: 'rgba(27, 75, 79, 0.08)',
                tension: 0.35,
                fill: true,
                borderWidth: 2.5,
                pointRadius: 4,
                pointBackgroundColor: '#1B4B4F',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(28,43,51,0.06)' }, ticks: { callback: (v) => '₱' + v.toLocaleString() } },
                x: { grid: { display: false } }
            }
        }
    });

    // Most Availed Services
    new Chart(document.getElementById('servicesChart'), {
        type: 'bar',
        data: {
            labels: serviceRows.map(s => s.service_type),
            datasets: [{
                label: 'Times Availed',
                data: serviceRows.map(s => s.total),
                backgroundColor: ['#1B4B4F', '#C98A3E', '#3F7D5C', '#C1533A', '#A8672A', '#5a8a8d'],
                borderRadius: 10,
                maxBarThickness: 46,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: 'rgba(28,43,51,0.06)' } },
                x: { grid: { display: false } }
            }
        }
    });

    // New Patients per Month
    new Chart(document.getElementById('patientsChart'), {
        type: 'line',
        data: {
            labels: patientRows.map(r => formatMonth(r.month)),
            datasets: [{
                label: 'New Patients',
                data: patientRows.map(r => r.total),
                borderColor: '#C98A3E',
                backgroundColor: 'rgba(201, 138, 62, 0.08)',
                tension: 0.35,
                fill: true,
                borderWidth: 2.5,
                pointRadius: 4,
                pointBackgroundColor: '#C98A3E',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: 'rgba(28,43,51,0.06)' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection