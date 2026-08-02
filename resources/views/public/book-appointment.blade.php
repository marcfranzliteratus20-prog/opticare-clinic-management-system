<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Appointment — OptiCare</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:500,600,700|inter:400,500,600,700" rel="stylesheet" />

    <style>
        :root {
            --oc-bg: #F7F5F0;
            --oc-ink: #1C2B33;
            --oc-teal: #1B4B4F;
            --oc-teal-dark: #123638;
            --oc-gold: #C98A3E;
            --oc-sage: #3F7D5C;
            --oc-terracotta: #C1533A;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--oc-bg);
            color: var(--oc-ink);
            min-height: 100vh;
            margin: 0;
        }

        .page-wrap {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .back-link {
            color: var(--oc-teal);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 18px;
        }
        .back-link:hover { color: var(--oc-teal-dark); }

        .booking-shell {
            display: grid;
            grid-template-columns: 0.85fr 1.15fr;
            border-radius: 26px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(28,43,51,0.1);
        }

        /* LEFT: branded info panel */
        .info-panel {
            position: relative;
            overflow: hidden;
            background: linear-gradient(155deg, var(--oc-teal), var(--oc-teal-dark));
            color: #fff;
            padding: 44px 36px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .info-panel .eyebrow {
            text-transform: uppercase;
            letter-spacing: 0.14em;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--oc-gold);
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .info-panel h1 {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 1.9rem;
            line-height: 1.25;
            margin-bottom: 14px;
            position: relative;
            z-index: 1;
        }

        .info-panel .lead {
            color: rgba(255,255,255,0.78);
            font-size: 0.92rem;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        .info-perks { position: relative; z-index: 1; }

        .info-perks li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 16px;
            font-size: 0.88rem;
            color: rgba(255,255,255,0.9);
            list-style: none;
        }

        .info-perks i {
            color: var(--oc-gold);
            font-size: 1rem;
            margin-top: 2px;
        }

        .status-link {
            position: relative;
            z-index: 1;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.15);
            font-size: 0.85rem;
            color: rgba(255,255,255,0.7);
        }

        .status-link a { color: var(--oc-gold); font-weight: 600; text-decoration: none; }
        .status-link a:hover { text-decoration: underline; }

        /* Decorative Snellen chart */
        .snellen {
            position: absolute;
            bottom: -10px;
            right: -20px;
            text-align: right;
            font-weight: 700;
            color: rgba(255,255,255,0.06);
            line-height: 1.1;
            letter-spacing: 0.06em;
            pointer-events: none;
            z-index: 0;
        }
        .snellen div:nth-child(1) { font-size: 4rem; }
        .snellen div:nth-child(2) { font-size: 2.8rem; }
        .snellen div:nth-child(3) { font-size: 2rem; }

        /* RIGHT: form panel */
        .form-panel {
            background: #fff;
            padding: 44px 40px;
        }

        .form-panel h2 {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 1.3rem;
            margin-bottom: 4px;
        }

        .form-panel .form-subtitle { color: #7a8a8e; font-size: 0.88rem; margin-bottom: 24px; }

        .field { margin-bottom: 16px; }

        .field label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #5a6b70;
            margin-bottom: 6px;
        }

        .field label i { color: var(--oc-teal); font-size: 0.9rem; }

        .field input, .field select, .field textarea {
            width: 100%;
            border: 1px solid rgba(28,43,51,0.14);
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 0.92rem;
            font-family: 'Inter', sans-serif;
            color: var(--oc-ink);
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .field input:focus, .field select:focus, .field textarea:focus {
            border-color: var(--oc-teal);
            box-shadow: 0 0 0 3px rgba(27,75,79,0.1);
        }

        .row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

        .btn-submit {
            background: var(--oc-teal);
            color: #fff;
            border: none;
            padding: 13px 28px;
            border-radius: 24px;
            font-weight: 600;
            width: 100%;
            font-size: 0.95rem;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover { background: var(--oc-teal-dark); }

        .alert-box {
            border-radius: 14px;
            padding: 14px 18px;
            font-size: 0.88rem;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .alert-success { background: rgba(63,125,92,0.1); color: var(--oc-sage); }
        .alert-danger { background: rgba(193,83,58,0.1); color: var(--oc-terracotta); }
        .alert-box i { margin-top: 2px; }

        @media (max-width: 800px) {
            .booking-shell { grid-template-columns: 1fr; border-radius: 22px; }
            .info-panel { padding: 34px 28px; }
            .form-panel { padding: 32px 26px; }
        }

        @media (max-width: 500px) {
            .row-2 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="page-wrap">
    <a href="/" class="back-link"><i class="bi bi-arrow-left"></i> Back to Home</a>

    <div class="booking-shell">

        <!-- LEFT: branded info panel -->
        <div class="info-panel">
            <div>
                <p class="eyebrow">Galvez Optical Clinic</p>
                <h1>See clearly, book easily.</h1>
                <p class="lead">Fill out the form and our staff will confirm your schedule shortly after.</p>

                <ul class="info-perks">
                    <li><i class="bi bi-calendar-check"></i> No need to call — book in a few minutes</li>
                    <li><i class="bi bi-eyeglasses"></i> Eye checkups, frame &amp; contact lens fitting</li>
                    <li><i class="bi bi-telephone"></i> We'll confirm your schedule by phone</li>
                </ul>
            </div>

            <div class="status-link">
                Already booked? <a href="{{ route('booking.status.form') }}">Check your appointment status</a>
            </div>

            <div class="snellen" aria-hidden="true">
                <div>E</div>
                <div>F&nbsp;P</div>
                <div>T&nbsp;O&nbsp;Z</div>
            </div>
        </div>

        <!-- RIGHT: form panel -->
        <div class="form-panel">
            <h2>Book an Appointment</h2>
            <p class="form-subtitle">All fields are required unless marked optional.</p>

            @if(session('success'))
                <div class="alert-box alert-success">
                    <i class="bi bi-check-circle-fill"></i> <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert-box alert-danger">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span>
                        <strong>Please fix the following:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </span>
                </div>
            @endif

            <form action="{{ route('booking.store') }}" method="POST">
                @csrf

                <div class="field">
                    <label><i class="bi bi-person"></i> Full Name</label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" required>
                </div>

                <div class="row-2">
                    <div class="field">
                        <label><i class="bi bi-calendar3"></i> Age</label>
                        <input type="number" name="age" min="0" max="120" value="{{ old('age') }}" required>
                    </div>
                    <div class="field">
                        <label><i class="bi bi-gender-ambiguous"></i> Gender</label>
                        <select name="gender" required>
                            <option value="">Select</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label><i class="bi bi-telephone"></i> Contact Number</label>
                    <input type="text" name="contact_number" value="{{ old('contact_number') }}"
                           placeholder="e.g. 09XXXXXXXXX" required>
                </div>

                <div class="field">
                    <label><i class="bi bi-geo-alt"></i> Address</label>
                    <textarea name="address" rows="2" required>{{ old('address') }}</textarea>
                </div>

             <div class="field">
    <label><i class="bi bi-eyeglasses"></i> Reason for Visit</label>

    

        <option value="Comprehensive Eye Examination" {{ old('type') == 'Comprehensive Eye Examination' ? 'selected' : '' }}>
            Comprehensive Eye Examination
        </option>

        <option value="Prescription Eyeglasses" {{ old('type') == 'Prescription Eyeglasses' ? 'selected' : '' }}>
            Prescription Eyeglasses
        </option>

        <option value="Contact Lens Fitting and Assessment" {{ old('type') == 'Contact Lens Fitting and Assessment' ? 'selected' : '' }}>
            Contact Lens Fitting and Assessment
        </option>

        <option value="Ishihara Color Vision Test" {{ old('type') == 'Ishihara Color Vision Test' ? 'selected' : '' }}>
            Ishihara Color Vision Test
        </option>

        <option value="Eye Condition Certification" {{ old('type') == 'Eye Condition Certification' ? 'selected' : '' }}>
            Eye Condition Certification
        </option>

        <option value="Eyewear Accessories" {{ old('type') == 'Eyewear Accessories' ? 'selected' : '' }}>
            Eyewear Accessories
        </option>

        <option value="Eyewear Repair and Maintenance" {{ old('type') == 'Eyewear Repair and Maintenance' ? 'selected' : '' }}>
            Eyewear Repair and Maintenance
        </option>

        <option value="Other" {{ old('type') == 'Other' ? 'selected' : '' }}>
            Other
        </option>
    </select>
</div>
                <div class="row-2">
                    <div class="field">
                        <label><i class="bi bi-calendar-event"></i> Preferred Date</label>
                        <input type="date" name="appointment_date" min="{{ date('Y-m-d') }}"
                               value="{{ old('appointment_date') }}" required>
                    </div>
                    <div class="field">
                        <label><i class="bi bi-clock"></i> Preferred Time</label>
                        <input type="time" name="appointment_time" value="{{ old('appointment_time') }}" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="bi bi-send-check"></i> Submit Appointment Request
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>