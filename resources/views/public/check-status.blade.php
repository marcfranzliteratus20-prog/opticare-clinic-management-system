<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Appointment Status — OptiCare</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:500,600,700|inter:400,500,600,700" rel="stylesheet" />

    <style>
        :root {
            --oc-bg: #F7F5F0;
            --oc-ink: #1C2B33;
            --oc-teal: #1B4B4F;
            --oc-gold: #C98A3E;
            --oc-amber-dark: #A8672A;
            --oc-sage: #3F7D5C;
            --oc-terracotta: #C1533A;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--oc-bg);
            color: var(--oc-ink);
            min-height: 100vh;
            margin: 0;
            padding: 40px 20px;
        }

        .wrap { max-width: 680px; margin: 0 auto; }

        .back-link {
            color: var(--oc-teal);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 20px;
        }

        .card-box {
            background: #fff;
            border-radius: 22px;
            padding: 36px;
            box-shadow: 0 4px 20px rgba(28,43,51,0.06);
        }

        .eyebrow {
            text-transform: uppercase;
            letter-spacing: 0.12em;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--oc-gold);
            margin-bottom: 6px;
        }

        h1 {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 1.7rem;
            margin-bottom: 4px;
        }

        .subtitle { color: #7a8a8e; font-size: 0.92rem; margin-bottom: 26px; }

        .search-form {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .search-form input {
            flex: 1;
            border: 1px solid rgba(28,43,51,0.14);
            border-radius: 12px;
            padding: 11px 14px;
            font-size: 0.92rem;
            outline: none;
        }

        .search-form input:focus { border-color: var(--oc-teal); }

        .btn-search {
            background: var(--oc-teal);
            color: #fff;
            border: none;
            padding: 11px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .btn-search:hover { background: #123638; color: #fff; }

        .oc-table { width: 100%; border-collapse: collapse; margin-top: 20px; }

        .oc-table thead th {
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-size: 0.68rem;
            font-weight: 600;
            color: #8a8a85;
            padding: 10px 14px;
            border-bottom: 1px solid rgba(28,43,51,0.08);
        }

        .oc-table tbody td {
            padding: 12px 14px;
            border-bottom: 1px solid rgba(28,43,51,0.06);
            font-size: 0.88rem;
        }

        .oc-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .oc-badge-gold { background: rgba(201,138,62,0.15); color: var(--oc-amber-dark); }
        .oc-badge-teal { background: rgba(27,75,79,0.15); color: var(--oc-teal); }
        .oc-badge-sage { background: rgba(63,125,92,0.15); color: var(--oc-sage); }
        .oc-badge-terracotta { background: rgba(193,83,58,0.15); color: var(--oc-terracotta); }

        .empty-state {
            text-align: center;
            padding: 30px 10px;
            color: #9a9a94;
        }
    </style>
</head>
<body>

<div class="wrap">
    <a href="/" class="back-link"><i class="bi bi-arrow-left"></i> Back to Home</a>

    <div class="card-box">
        <p class="eyebrow">Galvez Optical Clinic</p>
        <h1>Check Appointment Status</h1>
        <p class="subtitle">Enter the contact number you used when booking to see your appointment status.</p>

        <form action="{{ route('booking.status') }}" method="POST" class="search-form">
            @csrf
            <input type="text" name="contact_number" placeholder="e.g. 09XXXXXXXXX"
                   value="{{ $contact_number ?? old('contact_number') }}" required>
            <button type="submit" class="btn-search">Check</button>
        </form>

        @if($errors->any())
            <p style="color: var(--oc-terracotta); font-size: 0.85rem;">{{ $errors->first() }}</p>
        @endif

        @if(!empty($searched))
            @if($appointments->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-calendar-x" style="font-size: 1.8rem;"></i>
                    <p class="mt-2 mb-0">No appointments found for this contact number.</p>
                </div>
            @else
                <table class="oc-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Type</th>
                            <th>Doctor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            @php
                                $status = strtolower(trim((string) $appointment->status));
                            @endphp
                            <tr>
                                <td>{{ $appointment->appointment_date ? (is_a($appointment->appointment_date, \Carbon\CarbonInterface::class) ? $appointment->appointment_date->format('M d, Y') : $appointment->appointment_date) : '—' }}</td>
                                <td>{{ $appointment->appointment_time ?? '—' }}</td>
                                <td>{{ $appointment->type ?? 'New Checkup' }}</td>
                                <td>{{ $appointment->doctor_name ?? 'To be assigned' }}</td>
                                <td>
                                    @if($status === 'pending')
                                        <span class="oc-badge oc-badge-gold">Pending Confirmation</span>
                                    @elseif($status === 'approved')
                                        <span class="oc-badge oc-badge-teal">Approved</span>
                                    @elseif($status === 'completed')
                                        <span class="oc-badge oc-badge-sage">Completed</span>
                                    @elseif($status === 'cancelled' || $status === 'rejected')
                                        <span class="oc-badge oc-badge-terracotta">{{ ucfirst($appointment->status) }}</span>
                                    @else
                                        <span class="oc-badge oc-badge-gold">{{ $appointment->status }}</span>
                                    @endif

                                    @if(!empty($appointment->message))
                                        <div class="mt-1" style="font-size: 0.78rem; color: #6c757d;">
                                            <i class="bi bi-info-circle me-1"></i>{{ $appointment->message }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endif
    </div>
</div>

</body>
</html>