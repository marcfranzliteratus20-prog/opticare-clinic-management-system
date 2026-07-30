<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>OptiCare Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #222;
        }
        h1 {
            font-size: 20px;
            margin-bottom: 0;
        }
        .subtitle {
            color: #666;
            margin-top: 4px;
            margin-bottom: 20px;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .summary-table td {
            border: 1px solid #ddd;
            padding: 8px;
            width: 20%;
        }
        .summary-table .label {
            display: block;
            color: #666;
            font-size: 10px;
        }
        .summary-table .value {
            display: block;
            font-size: 15px;
            font-weight: bold;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        table.data th, table.data td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            text-align: left;
            font-size: 11px;
        }
        table.data th {
            background: #f4f4f4;
        }
        .text-right {
            text-align: right;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
            margin-top: 10px;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>
<body>

    <h1>OptiCare Clinic Report</h1>
    <p class="subtitle">Galvez Optical Clinic Management System · Generated {{ now()->format('F j, Y g:i A') }}</p>

    <table class="summary-table">
        <tr>
            <td>
                <span class="label">Total Revenue</span>
                <span class="value">₱{{ number_format($totalRevenue, 2) }}</span>
            </td>
            <td>
                <span class="label">Unpaid Balance</span>
                <span class="value">₱{{ number_format($totalUnpaid, 2) }}</span>
            </td>
            <td>
                <span class="label">Total Patients</span>
                <span class="value">{{ $totalPatients }}</span>
            </td>
            <td>
                <span class="label">Total Appointments</span>
                <span class="value">{{ $totalAppointments }}</span>
            </td>
            <td>
                <span class="label">Inventory Value</span>
                <span class="value">₱{{ number_format($inventoryValuation, 2) }}</span>
            </td>
        </tr>
    </table>

    <div class="section-title">Monthly Revenue</div>
    <table class="data">
        <thead>
            <tr>
                <th>Month</th>
                <th class="text-right">Revenue</th>
            </tr>
        </thead>
        <tbody>
            @forelse($monthlyRevenue as $row)
                <tr>
                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $row->month)->format('F Y') }}</td>
                    <td class="text-right">₱{{ number_format($row->total, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="2">No paid billing records yet.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Most Availed Services</div>
    <table class="data">
        <thead>
            <tr>
                <th>Service</th>
                <th class="text-right">Count</th>
                <th class="text-right">Revenue</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topServices as $service)
                <tr>
                    <td>{{ $service->service_type }}</td>
                    <td class="text-right">{{ $service->total }}</td>
                    <td class="text-right">₱{{ number_format($service->revenue, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="3">No billing records yet.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">New Patients per Month</div>
    <table class="data">
        <thead>
            <tr>
                <th>Month</th>
                <th class="text-right">New Patients</th>
            </tr>
        </thead>
        <tbody>
            @forelse($monthlyPatients as $row)
                <tr>
                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $row->month)->format('F Y') }}</td>
                    <td class="text-right">{{ $row->total }}</td>
                </tr>
            @empty
                <tr><td colspan="2">No patients registered yet.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        This report was generated automatically by OptiCare Clinic Management System.
    </div>

</body>
</html>