<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OptiCare — Galvez Optical Clinic</title>

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
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--oc-bg);
            color: var(--oc-ink);
            margin: 0;
        }

        .navbar {
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .logo {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 1.3rem;
            color: var(--oc-teal);
        }

        .navbar .logo i { color: var(--oc-gold); }

        .navbar a.login-link {
            color: var(--oc-teal);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            border: 1px solid rgba(27,75,79,0.25);
            padding: 8px 18px;
            border-radius: 20px;
        }

        .navbar a.login-link:hover { background: rgba(27,75,79,0.06); }

        .hero {
            position: relative;
            overflow: hidden;
            margin: 20px 40px;
            border-radius: 28px;
            background: linear-gradient(135deg, var(--oc-teal), var(--oc-teal-dark));
            color: #fff;
            padding: 70px 50px;
        }

        .hero-content { position: relative; z-index: 2; max-width: 560px; }

        .hero p.eyebrow {
            text-transform: uppercase;
            letter-spacing: 0.14em;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--oc-gold);
            margin-bottom: 12px;
        }

        .hero h1 {
            font-family: 'Fraunces', serif;
            font-size: 2.6rem;
            font-weight: 600;
            line-height: 1.2;
            margin-bottom: 16px;
        }

        .hero p.subtitle {
            color: rgba(255,255,255,0.8);
            font-size: 1.05rem;
            margin-bottom: 28px;
        }

        .hero .btn-book {
            background: var(--oc-gold);
            color: #fff;
            border: none;
            padding: 14px 32px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            font-size: 1rem;
        }

        .hero .btn-book:hover { background: #b57834; color: #fff; }

        .snellen {
            position: absolute;
            top: 50%;
            right: -10px;
            transform: translateY(-50%);
            z-index: 1;
            text-align: right;
            font-weight: 700;
            color: rgba(255,255,255,0.08);
            line-height: 1.15;
            letter-spacing: 0.08em;
            user-select: none;
        }
        .snellen div:nth-child(1) { font-size: 5.5rem; }
        .snellen div:nth-child(2) { font-size: 4rem; }
        .snellen div:nth-child(3) { font-size: 2.8rem; }
        .snellen div:nth-child(4) { font-size: 2rem; }

        .features {
            padding: 60px 40px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .feature-card {
            background: #fff;
            border-radius: 18px;
            padding: 28px;
            border: 1px solid rgba(28,43,51,0.06);
            box-shadow: 0 2px 10px rgba(28,43,51,0.04);
            height: 100%;
        }

        .feature-card i {
            font-size: 1.6rem;
            color: var(--oc-teal);
            margin-bottom: 12px;
        }

        .feature-card h5 {
            font-family: 'Fraunces', serif;
            font-weight: 600;
        }

        .feature-card p {
            color: #7a8a8e;
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        footer {
            text-align: center;
            padding: 30px;
            color: #9a9a94;
            font-size: 0.85rem;
        }

        @media (max-width: 767px) {
            .hero { padding: 40px 28px; }
            .hero h1 { font-size: 1.9rem; }
            .snellen { display: none; }
            .navbar { padding: 16px 20px; }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="logo"><i class="bi bi-eyeglasses me-2"></i>OptiCare</div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('booking.status.form') }}" class="login-link">Check Appointment Status</a>
            <a href="{{ route('login') }}" class="login-link">Staff Login</a>
        </div>
    </div>

    <div class="hero">
        <div class="hero-content">
            <p class="eyebrow">Galvez Optical Clinic</p>
            <h1>See clearly. Book your eye exam online.</h1>
            <p class="subtitle">
                Schedule your appointment in a few clicks — no need to call or visit in person.
                Our staff will confirm your schedule shortly after.
            </p>
            <a href="{{ route('booking.create') }}" class="btn-book">
                <i class="bi bi-calendar-plus"></i> Book an Appointment
            </a>
        </div>

        <div class="snellen" aria-hidden="true">
            <div>E</div>
            <div>F&nbsp;&nbsp;P</div>
            <div>T&nbsp;O&nbsp;Z</div>
            <div>L&nbsp;P&nbsp;E&nbsp;D</div>
        </div>
    </div>

    <div class="features">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="bi bi-calendar-check"></i>
                    <h5>Easy Scheduling</h5>
                    <p>Pick a date and time that works for you — no phone calls needed.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="bi bi-eyeglasses"></i>
                    <h5>Eye Checkups &amp; Eyeglasses</h5>
                    <p>Comprehensive eye exams, frames, and lens fitting services.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="bi bi-telephone"></i>
                    <h5>Confirmed by Our Staff</h5>
                    <p>We'll reach out to confirm your appointment details before your visit.</p>
                </div>
            </div>
        </div>
    </div>

    <footer>
        &copy; {{ date('Y') }} Galvez Optical Clinic &mdash; OptiCare Clinic Management System
    </footer>

</body>
</html>