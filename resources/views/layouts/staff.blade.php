<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>OptiCare Clinic Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:500,600,700|inter:400,500,600,700" rel="stylesheet">

    <style>
        :root {
            --oc-bg: #F7F5F0;
            --oc-ink: #1C2B33;
            --oc-teal: #1B4B4F;
            --oc-teal-dark: #123638;
            --oc-teal-light: #E8F0EF;
            --oc-gold: #C98A3E;
            --oc-amber-dark: #A8672A;
            --oc-sage: #3F7D5C;
            --oc-terracotta: #C1533A;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: var(--oc-bg);
            color: var(--oc-ink);
            margin: 0;
        }

        /* =========================
           TOP BAR
        ========================= */

        .topbar {
            height: 70px;
            background: linear-gradient(
                90deg,
                var(--oc-teal),
                var(--oc-teal-dark)
            );

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 25px;

            color: white;

            box-shadow: 0 4px 15px rgba(18, 54, 56, 0.15);

            position: fixed;
            width: 100%;
            top: 0;
            left: 0;

            z-index: 1000;
        }

        .topbar .logo {
            font-family: 'Fraunces', serif;
            font-size: 1.3rem;
            font-weight: 600;

            display: flex;
            align-items: center;
        }

        .topbar .logo i {
            color: var(--oc-gold);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        /* SEARCH */

        .topbar-search {
            position: relative;
        }

        .topbar-search i {
            position: absolute;

            left: 16px;
            top: 50%;

            transform: translateY(-50%);

            color: rgba(255,255,255,0.55);

            font-size: 0.85rem;
        }

        .topbar-search input {
            background: rgba(255,255,255,0.12);

            border: 1px solid rgba(255,255,255,0.18);

            color: white;

            padding: 8px 16px 8px 38px;

            border-radius: 20px;

            width: 230px;

            font-size: 0.85rem;

            transition: 0.2s ease;
        }

        .topbar-search input::placeholder {
            color: rgba(255,255,255,0.55);
        }

        .topbar-search input:focus {
            outline: none;
            background: rgba(255,255,255,0.20);
        }

        /* =========================
           NOTIFICATION
        ========================= */

        .topbar-icon-btn {
            color: rgba(255,255,255,0.9);

            font-size: 1.15rem;

            position: relative;

            text-decoration: none;

            display: flex;
            align-items: center;
        }

        .topbar-icon-btn:hover {
            color: white;
        }

        .topbar-icon-btn .badge {
            font-size: 0.6rem;

            background: var(--oc-terracotta) !important;

            position: absolute;

            top: -7px;
            right: -9px;
        }

        .dropdown-menu {
            border: none;

            border-radius: 14px;

            min-width: 220px;
        }

        .dropdown-header {
            font-family: 'Fraunces', serif;

            color: var(--oc-teal);
        }

        .dropdown-item {
            font-size: 0.88rem;

            padding: 9px 14px;
        }

        .dropdown-item:hover {
            background: var(--oc-teal-light);

            color: var(--oc-teal);
        }

        /* =========================
           USER
        ========================= */

        .topbar-user {
            display: flex;

            align-items: center;

            gap: 10px;
        }

        .topbar-avatar {
            width: 36px;
            height: 36px;

            border-radius: 50%;

            background: var(--oc-gold);

            color: var(--oc-teal-dark);

            display: flex;

            align-items: center;
            justify-content: center;

            font-weight: 700;

            font-size: 0.9rem;

            text-decoration: none;
        }

        .topbar-user-info {
            font-size: 0.8rem;

            line-height: 1.3;
        }

        .topbar-user-info strong {
            display: block;

            font-size: 0.88rem;
        }

        .topbar-user-info span {
            color: rgba(255,255,255,0.65);
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            width: 250px;

            height: 100vh;

            position: fixed;

            top: 70px;
            left: 0;

            padding: 24px 16px;

            background: #ffffff;

            box-shadow: 4px 0 20px rgba(28, 43, 51, 0.04);

            border-right: 1px solid rgba(28, 43, 51, 0.06);

            overflow-y: auto;
        }

        .sidebar-header {
            margin-bottom: 26px;

            padding: 16px;

            border-radius: 16px;

            background: linear-gradient(
                135deg,
                var(--oc-teal),
                var(--oc-teal-dark)
            );

            color: white;

            font-family: 'Fraunces', serif;

            font-weight: 600;

            font-size: 1.02rem;

            text-align: center;
        }

        .sidebar-header small {
            display: block;

            font-family: 'Inter', sans-serif;

            font-size: 0.68rem;

            font-weight: 500;

            letter-spacing: 0.06em;

            text-transform: uppercase;

            opacity: 0.7;

            margin-top: 4px;
        }

        .sidebar a,
        .sidebar form button {
            display: flex;

            align-items: center;

            width: 100%;

            padding: 11px 14px;

            margin-bottom: 6px;

            border-radius: 12px;

            text-decoration: none;

            color: #5a6b70;

            font-weight: 500;

            font-size: 0.9rem;

            transition: all 0.2s ease;

            background: none;

            border: none;

            text-align: left;

            cursor: pointer;
        }

        .sidebar a:hover,
        .sidebar form button:hover {
            background: var(--oc-teal-light);

            color: var(--oc-teal);
        }

        .sidebar a.active {
            background: var(--oc-teal);

            color: white;

            box-shadow: 0 4px 12px rgba(27, 75, 79, 0.25);
        }

        .sidebar-divider {
            border: none;

            border-top: 1px solid rgba(28,43,51,0.08);

            margin: 14px 0;
        }

        .logout-btn {
            color: var(--oc-terracotta) !important;
        }

        .logout-btn:hover {
            background: rgba(193,83,58,0.08) !important;
        }

        /* =========================
           CONTENT
        ========================= */

        .content {
            margin-left: 250px;

            margin-top: 70px;

            padding: 28px;

            min-height: calc(100vh - 70px);
        }

        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 768px) {

            .sidebar {
                width: 220px;
            }

            .content {
                margin-left: 220px;
            }

            .topbar-search {
                display: none;
            }

            .topbar-user-info {
                display: none;
            }
        }
    </style>
</head>

<body>

<!-- =========================================
     TOP BAR
========================================= -->

<div class="topbar">

    <!-- LOGO -->

    <div class="logo">
        <i class="bi bi-eyeglasses me-2"></i>
        OptiCare
    </div>


    <div class="topbar-right">

        <!-- SEARCH -->

        <form
            action="{{ route('search') }}"
            method="GET"
            class="topbar-search"
        >

            <i class="bi bi-search"></i>

            <input
                type="text"
                name="search"
                placeholder="Search anything..."
                value="{{ request('search') }}"
            >

        </form>


        <!-- =========================================
             NOTIFICATION
        ========================================== -->

        <div class="dropdown">

            <a
                href="#"
                class="topbar-icon-btn"
                id="notificationDropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >

                <i class="bi bi-bell-fill"></i>

                @if(($totalNotifications ?? 0) > 0)

                    <span class="badge rounded-pill">

                        {{ $totalNotifications }}

                    </span>

                @endif

            </a>


            <ul
                class="dropdown-menu dropdown-menu-end shadow mt-2"
                aria-labelledby="notificationDropdown"
            >

                <li>
                    <h6 class="dropdown-header">
                        Notifications
                    </h6>
                </li>


                <!-- APPOINTMENTS -->

                <li>
                    <a
                        class="dropdown-item"
                        href="{{ route('appointments.index') }}"
                    >

                        📅

                        {{ $todayAppointments ?? 0 }}

                        Appointments

                    </a>
                </li>


                <!-- LOW STOCK -->

                <li>
                    <a
                        class="dropdown-item"
                        href="{{ route('inventory.index') }}"
                    >

                        ⚠️

                        {{ $lowStock ?? 0 }}

                        Low Stock

                    </a>
                </li>


                <!-- UNPAID BILLING -->

                <li>
                    <a
                        class="dropdown-item"
                        href="{{ route('billing.index') }}"
                    >

                        💳

                        {{ $unpaidBilling ?? 0 }}

                        Unpaid

                    </a>
                </li>

            </ul>

        </div>


        <!-- =========================================
             STAFF USER
        ========================================== -->

        <div class="topbar-user">

            <a
                href="{{ route('profile.edit') }}"
                class="topbar-avatar"
            >

                {{ strtoupper(substr(session('user_name', 'S'), 0, 1)) }}

            </a>


            <div class="topbar-user-info">

                <strong>
                    {{ session('user_name', 'Staff') }}
                </strong>

                <span>
                    Staff
                </span>

            </div>

        </div>

    </div>

</div>


<!-- =========================================
     SIDEBAR
========================================= -->

<div class="sidebar">

    <div class="sidebar-header">

        <i class="bi bi-eyeglasses me-2"></i>

        <span>OptiCare</span>

        <small>
            Staff Panel
        </small>

    </div>


    <!-- DASHBOARD -->

    <a
        href="{{ route('staff.dashboard') }}"
        class="{{ request()->routeIs('staff.dashboard') ? 'active' : '' }}"
    >

        <i class="bi bi-speedometer2 me-2"></i>

        Dashboard

    </a>


    <!-- PATIENTS -->

    <a
        href="{{ route('patients.index') }}"
        class="{{ request()->routeIs('patients.*') ? 'active' : '' }}"
    >

        <i class="bi bi-person-lines-fill me-2"></i>

        Patients

    </a>


    <!-- APPOINTMENTS -->

    <a
        href="{{ route('appointments.index') }}"
        class="{{ request()->routeIs('appointments.*') ? 'active' : '' }}"
    >

        <i class="bi bi-calendar-check me-2"></i>

        Appointments

    </a>


    <!-- BILLING -->

    <a
        href="{{ route('billing.index') }}"
        class="{{ request()->routeIs('billing.*') ? 'active' : '' }}"
    >

        <i class="bi bi-receipt me-2"></i>

        Billing

    </a>


    <!-- INVENTORY -->

    <a
        href="{{ route('inventory.index') }}"
        class="{{ request()->routeIs('inventory.*') ? 'active' : '' }}"
    >

        <i class="bi bi-box-seam me-2"></i>

        Inventory

    </a>


    <hr class="sidebar-divider">


    <!-- ACCOUNT SETTINGS -->

    <a
        href="{{ route('profile.edit') }}"
        class="{{ request()->routeIs('profile.*') ? 'active' : '' }}"
    >

        <i class="bi bi-person-gear me-2"></i>

        Account Settings

    </a>


    <!-- LOGOUT -->

    <form
        action="{{ route('logout') }}"
        method="POST"
    >

        @csrf

        <button
            type="submit"
            class="logout-btn"
        >

            <i class="bi bi-box-arrow-right me-2"></i>

            Logout

        </button>

    </form>

</div>


<!-- =========================================
     PAGE CONTENT
========================================= -->

<div class="content">

    @yield('content')

</div>


<!-- BOOTSTRAP -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>