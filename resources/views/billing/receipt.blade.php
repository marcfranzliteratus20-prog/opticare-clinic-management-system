<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt #{{ str_pad($billing->id, 6, '0', STR_PAD_LEFT) }} — OptiCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:500,600,700|inter:400,500,600,700" rel="stylesheet" />

    <style>
        :root {
            --oc-ink: #1C2B33;
            --oc-teal: #1B4B4F;
            --oc-gold: #C98A3E;
            --oc-sage: #3F7D5C;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #F7F5F0;
            color: var(--oc-ink);
            padding: 40px 20px;
        }

        .receipt {
            max-width: 560px;
            margin: 0 auto;
            background: #fff;
            border-radius: 18px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(28,43,51,0.08);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 1.4rem;
            color: var(--oc-teal);
        }

        .brand i { color: var(--oc-gold); }

        .clinic-name { color: #7a8a8e; font-size: 0.85rem; margin-top: 2px; }

        .receipt-title {
            text-align: right;
        }

        .receipt-title h2 {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 1.3rem;
            margin-bottom: 2px;
        }

        .receipt-title span { color: #9a9a94; font-size: 0.85rem; }

        hr { border-color: rgba(28,43,51,0.1); margin: 24px 0; }

        .row-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.92rem;
        }

        .row-line .label { color: #7a8a8e; }
        .row-line .value { font-weight: 600; }

        .total-line {
            display: flex;
            justify-content: space-between;
            font-size: 1.2rem;
            font-weight: 700;
            padding-top: 14px;
            border-top: 1px dashed rgba(28,43,51,0.2);
            margin-top: 14px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            background: rgba(63,125,92,0.12);
            color: var(--oc-sage);
        }

        .footer-note {
            text-align: center;
            color: #9a9a94;
            font-size: 0.78rem;
            margin-top: 28px;
        }

        .print-bar {
            max-width: 560px;
            margin: 0 auto 16px;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        .btn-print {
            background: var(--oc-teal);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.88rem;
        }

        @media print {
            body { background: #fff; padding: 0; }
            .print-bar { display: none; }
            .receipt { box-shadow: none; }
        }
    </style>
</head>
<body>

    <div class="print-bar">
        <button class="btn-print" onclick="window.print()"><i class="bi bi-printer"></i> Print</button>
    </div>

    <div class="receipt">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <div class="brand"><i class="bi bi-eyeglasses"></i> OptiCare</div>
                <div class="clinic-name">Galvez Optical Clinic</div>
            </div>
            <div class="receipt-title">
                <h2>Receipt</h2>
                <span>#{{ str_pad($billing->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>

        <hr>

        <div class="row-line">
            <span class="label">Date</span>
            <span class="value">{{ $billing->created_at->format('M d, Y g:i A') }}</span>
        </div>
        <div class="row-line">
            <span class="label">Patient</span>
            <span class="value">{{ $billing->patient->full_name ?? 'Unknown patient' }}</span>
        </div>
        <div class="row-line">
            <span class="label">Service / Item</span>
            <span class="value">{{ $billing->service_type }}</span>
        </div>
        @if($billing->warranty_expiry)
            <div class="row-line">
                <span class="label">Warranty</span>
                <span class="value">Until {{ $billing->warranty_expiry->format('M d, Y') }}</span>
            </div>
        @endif
        <div class="row-line">
            <span class="label">Payment Status</span>
            <span class="status-badge">{{ $billing->payment_status }}</span>
        </div>

        <div class="total-line">
            <span>Total</span>
            <span>₱{{ number_format($billing->amount, 2) }}</span>
        </div>

        <p class="footer-note">
            This receipt was generated by OptiCare Clinic Management System. Please keep this for your records,
            especially for warranty claims.
        </p>
    </div>

</body>
</html>