@extends('layouts.app')

@section('content')
<div class="container-fluid oc-dashboard">

    <!-- Welcome Banner -->
    <div class="oc-banner mb-4">
        <div class="oc-banner-content">
            <div>
                <p class="oc-eyebrow">Galvez Optical Clinic</p>
                <h1 class="oc-title">Good day, let's see clearly today.</h1>
                <p class="oc-subtitle">
                    Manage patients, appointments, billing, and inventory in one place.
                </p>
            </div>

            <div class="oc-clock-block">
                <div class="oc-clock" id="clock"></div>
                <div class="oc-date" id="date"></div>
            </div>
        </div>

        <!-- Signature: Snellen eye chart, faded into the banner background -->
        <div class="oc-snellen" aria-hidden="true">
            <div>E</div>
            <div>F&nbsp;&nbsp;P</div>
            <div>T&nbsp;O&nbsp;Z</div>
            <div>L&nbsp;P&nbsp;E&nbsp;D</div>
            <div>P&nbsp;E&nbsp;C&nbsp;F&nbsp;D</div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="oc-card oc-search-card mb-4">
        <form action="{{ route('search') }}" method="GET" class="oc-search-form">
            <i class="bi bi-search"></i>
            <input type="search"
                   name="search"
                   placeholder="Search patients, appointments, billing, or inventory...">
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">

        <div class="col-6 col-lg-3">
            <div class="oc-card oc-stat" style="--accent: var(--oc-teal);">
                <i class="bi bi-people oc-stat-icon"></i>
                <span class="oc-stat-label">Total Patients</span>
                <span class="oc-stat-value">{{ $totalPatients }}</span>
                <span class="oc-stat-caption">Registered patients</span>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="oc-card oc-stat" style="--accent: var(--oc-gold);">
                <i class="bi bi-calendar-check oc-stat-icon"></i>
                <span class="oc-stat-label">Today</span>
                <span class="oc-stat-value">{{ $todayAppointments }}</span>
                <span class="oc-stat-caption">Appointments today</span>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="oc-card oc-stat" style="--accent: var(--oc-amber-dark);">
                <i class="bi bi-hourglass-split oc-stat-icon"></i>
                <span class="oc-stat-label">Pending</span>
                <span class="oc-stat-value">{{ $pendingAppointments }}</span>
                <span class="oc-stat-caption">Waiting consultations</span>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="oc-card oc-stat" style="--accent: var(--oc-sage);">
                <i class="bi bi-check-circle oc-stat-icon"></i>
                <span class="oc-stat-label">Completed</span>
                <span class="oc-stat-value">{{ $completedAppointments }}</span>
                <span class="oc-stat-caption">Finished consultations</span>
            </div>
        </div>
    </div>

    <!-- Module Cards -->
    <div class="row g-3">

        <div class="col-md-4">
            <a href="{{ route('inventory.index') }}" class="oc-card oc-module">
                <div class="oc-module-icon" style="--accent: var(--oc-teal);">
                    <i class="bi bi-eyeglasses"></i>
                </div>
                <div>
                    <h5>Inventory</h5>
                    <p>{{ $totalProducts }} products &middot; Frames, lenses, stocks</p>
                </div>
                <i class="bi bi-arrow-right oc-module-arrow"></i>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('billing.index') }}" class="oc-card oc-module">
                <div class="oc-module-icon" style="--accent: var(--oc-terracotta);">
                    <i class="bi bi-receipt"></i>
                </div>
                <div>
                    <h5>Billing</h5>
                    <p>{{ $unpaidBilling }} unpaid record{{ $unpaidBilling == 1 ? '' : 's' }}</p>
                </div>
                <i class="bi bi-arrow-right oc-module-arrow"></i>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('inventory.index') }}" class="oc-card oc-module">
                <div class="oc-module-icon" style="--accent: var(--oc-amber-dark);">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div>
                    <h5>Low Stock</h5>
                    <p>{{ $lowStock }} item{{ $lowStock == 1 ? '' : 's' }} need{{ $lowStock == 1 ? 's' : '' }} restock</p>
                </div>
                <i class="bi bi-arrow-right oc-module-arrow"></i>
            </a>
        </div>

    </div>
</div>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=fraunces:500,600,600i,700|inter:400,500,600,700" rel="stylesheet" />

<style>
    .oc-dashboard {
        --oc-bg: #F7F5F0;
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

    .oc-dashboard h1, .oc-dashboard h5 {
        font-family: 'Fraunces', Georgia, serif;
    }

    /* Card base */
    .oc-card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid rgba(28, 43, 51, 0.06);
        box-shadow: 0 2px 10px rgba(28, 43, 51, 0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    /* Banner */
    .oc-banner {
        position: relative;
        overflow: hidden;
        border-radius: 22px;
        background: linear-gradient(135deg, var(--oc-teal), #123638);
        padding: 36px 40px;
        color: #fff;
    }

    .oc-banner-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .oc-eyebrow {
        text-transform: uppercase;
        letter-spacing: 0.14em;
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--oc-gold);
        margin-bottom: 8px;
    }

    .oc-title {
        font-size: 1.9rem;
        font-weight: 600;
        margin-bottom: 8px;
        line-height: 1.25;
    }

    .oc-subtitle {
        color: rgba(255,255,255,0.75);
        margin-bottom: 0;
        font-size: 0.95rem;
    }

    .oc-clock-block {
        text-align: right;
    }

    .oc-clock {
        font-family: 'Fraunces', serif;
        font-size: 2rem;
        font-weight: 600;
        font-variant-numeric: tabular-nums;
    }

    .oc-date {
        color: rgba(255,255,255,0.6);
        font-size: 0.85rem;
    }

    /* Signature: Snellen eye chart watermark */
    .oc-snellen {
        position: absolute;
        top: 50%;
        right: -10px;
        transform: translateY(-50%);
        z-index: 1;
        text-align: right;
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.08);
        line-height: 1.15;
        letter-spacing: 0.08em;
        user-select: none;
        pointer-events: none;
    }
    .oc-snellen div:nth-child(1) { font-size: 5.5rem; }
    .oc-snellen div:nth-child(2) { font-size: 4rem; }
    .oc-snellen div:nth-child(3) { font-size: 2.8rem; }
    .oc-snellen div:nth-child(4) { font-size: 2rem; }
    .oc-snellen div:nth-child(5) { font-size: 1.4rem; }

    /* Search */
    .oc-search-card {
        padding: 6px 10px;
    }

    .oc-search-form {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 14px;
    }

    .oc-search-form i {
        color: var(--oc-teal);
    }

    .oc-search-form input {
        border: none;
        outline: none;
        flex: 1;
        font-size: 0.95rem;
        background: transparent;
        color: var(--oc-ink);
    }

    /* Stat cards */
    .oc-stat {
        padding: 22px;
        display: flex;
        flex-direction: column;
        gap: 4px;
        border-top: 3px solid var(--accent);
        height: 100%;
    }

    .oc-stat:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(28, 43, 51, 0.08);
    }

    .oc-stat-icon {
        font-size: 1.1rem;
        color: var(--accent);
        margin-bottom: 6px;
    }

    .oc-stat-label {
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-size: 0.7rem;
        font-weight: 600;
        color: #8a8a85;
    }

    .oc-stat-value {
        font-family: 'Fraunces', serif;
        font-size: 2.1rem;
        font-weight: 600;
        color: var(--oc-ink);
        line-height: 1.1;
    }

    .oc-stat-caption {
        font-size: 0.78rem;
        color: #9a9a94;
    }

    /* Module cards */
    .oc-module {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px;
        text-decoration: none;
        color: inherit;
        height: 100%;
    }

    .oc-module:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(28, 43, 51, 0.08);
        color: inherit;
    }

    .oc-module-icon {
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 14px;
        background: color-mix(in srgb, var(--accent) 14%, white);
        color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    .oc-module h5 {
        margin-bottom: 2px;
        font-size: 1.05rem;
        font-weight: 600;
    }

    .oc-module p {
        margin-bottom: 0;
        font-size: 0.82rem;
        color: #8a8a85;
    }

    .oc-module-arrow {
        margin-left: auto;
        color: #c7c7c0;
        transition: transform 0.2s ease, color 0.2s ease;
    }

    .oc-module:hover .oc-module-arrow {
        transform: translateX(4px);
        color: var(--oc-ink);
    }

    @media (max-width: 767px) {
        .oc-banner { padding: 28px 24px; }
        .oc-title { font-size: 1.5rem; }
        .oc-clock-block { text-align: left; }
        .oc-snellen { display: none; }
    }
</style>

<script>
function updateClock() {
    const now = new Date();
    document.getElementById('clock').innerHTML = now.toLocaleTimeString();
    document.getElementById('date').innerHTML = now.toLocaleDateString('en-US', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
    });
}
setInterval(updateClock, 1000);
updateClock();
</script>
@endsection