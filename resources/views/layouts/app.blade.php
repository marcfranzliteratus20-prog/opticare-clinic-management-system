<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>OptiCare Clinic Management System</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=fraunces:500,600,700|inter:400,500,600,700"
        rel="stylesheet"
    >

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


        * {
            box-sizing: border-box;
        }


        body {

            font-family: 'Inter', 'Segoe UI', sans-serif;

            background: var(--oc-bg);

            color: var(--oc-ink);

            margin: 0;

            min-height: 100vh;
        }


        /* =========================================================
           PAGINATION
        ========================================================= */

        .pagination svg,
        nav svg {

            width: 16px !important;
            height: 16px !important;
        }


        /* =========================================================
           TOP BAR
        ========================================================= */

        .topbar {

            height: 70px;

            background:
                linear-gradient(
                    90deg,
                    var(--oc-teal),
                    var(--oc-teal-dark)
                );

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 0 25px;

            color: white;

            box-shadow:
                0 4px 15px rgba(18, 54, 56, 0.15);

            position: fixed;

            width: 100%;

            top: 0;

            left: 0;

            z-index: 1050;
        }


        .topbar .logo {

            font-family: 'Fraunces', serif;

            font-size: 1.3rem;

            font-weight: 600;

            display: flex;

            align-items: center;

            white-space: nowrap;
        }


        .topbar .logo i {

            color: var(--oc-gold);
        }


        .topbar-right {

            display: flex;

            align-items: center;

            gap: 18px;
        }


        /* =========================================================
           SEARCH
        ========================================================= */

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

            pointer-events: none;
        }


        .topbar-search input {

            background: rgba(255,255,255,0.12);

            border:
                1px solid rgba(255,255,255,0.18);

            color: white;

            padding:
                8px
                16px
                8px
                38px;

            border-radius: 20px;

            width: 260px;

            font-size: 0.85rem;

            transition: 0.2s ease;
        }


        .topbar-search input::placeholder {

            color: rgba(255,255,255,0.55);
        }


        .topbar-search input:focus {

            outline: none;

            background: rgba(255,255,255,0.2);

            border-color:
                rgba(255,255,255,0.3);
        }


        /* =========================================================
           NOTIFICATION
        ========================================================= */

        .notification-wrapper {

            position: relative;
        }


        .topbar-icon-btn {

            color: rgba(255,255,255,0.95);

            font-size: 1.2rem;

            position: relative;

            text-decoration: none;

            width: 38px;

            height: 38px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            transition: 0.2s ease;
        }


        .topbar-icon-btn:hover {

            background:
                rgba(255,255,255,0.12);

            color: white;
        }


        .notification-badge {

            position: absolute;

            top: -3px;

            right: -5px;

            min-width: 18px;

            height: 18px;

            padding: 0 5px;

            border-radius: 20px;

            display: flex;

            align-items: center;

            justify-content: center;

            background:
                var(--oc-terracotta);

            color: white;

            font-size: 0.62rem;

            font-weight: 700;

            line-height: 1;
        }


        /* =========================================================
           USER
        ========================================================= */

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


        .dropdown-menu {

            border: none;

            border-radius: 14px;

            min-width: 230px;

            box-shadow:
                0 12px 35px rgba(28,43,51,0.14);
        }


        .dropdown-header {

            font-family: 'Fraunces', serif;

            color: var(--oc-teal);
        }


        .dropdown-item {

            padding: 10px 15px;
        }


        .dropdown-item:hover {

            background: var(--oc-teal-light);

            color: var(--oc-teal);
        }


        .dropdown-item:active {

            background: var(--oc-teal-light);

            color: var(--oc-ink);
        }


        /* =========================================================
           SIDEBAR
        ========================================================= */

        .sidebar {

            width: 260px;

            height: calc(100vh - 70px);

            position: fixed;

            top: 70px;

            left: 0;

            padding: 24px 16px;

            background: white;

            box-shadow:
                4px 0 20px rgba(28,43,51,0.04);

            border-right:
                1px solid rgba(28,43,51,0.06);

            overflow-y: auto;

            z-index: 1000;
        }


        .sidebar-header {

            margin-bottom: 26px;

            padding: 16px;

            border-radius: 16px;

            background:
                linear-gradient(
                    135deg,
                    var(--oc-teal),
                    var(--oc-teal-dark)
                );

            color: white;

            font-family: 'Fraunces', serif;

            font-weight: 600;

            font-size: 1.05rem;

            text-align: center;
        }


        .sidebar-header small {

            display: block;

            font-family: 'Inter', sans-serif;

            font-size: 0.7rem;

            font-weight: 500;

            letter-spacing: 0.06em;

            text-transform: uppercase;

            opacity: 0.7;

            margin-top: 4px;
        }


        .sidebar-link {

            display: flex;

            align-items: center;

            padding: 11px 14px;

            margin-bottom: 6px;

            border-radius: 12px;

            text-decoration: none;

            color: #5a6b70;

            font-weight: 500;

            font-size: 0.92rem;

            transition: all 0.2s ease;
        }


        .sidebar-link i {

            font-size: 1rem;

            width: 22px;
        }


        .sidebar-link:hover {

            background: var(--oc-teal-light);

            color: var(--oc-teal);
        }


        .sidebar-link.active {

            background: var(--oc-teal);

            color: white;

            box-shadow:
                0 4px 12px rgba(27,75,79,0.25);
        }


        .sidebar-link .badge {

            font-size: 0.68rem;

            font-weight: 600;

            margin-left: auto;
        }


        .sidebar-link .bg-warning {

            background: var(--oc-gold) !important;

            color: white !important;
        }


        .sidebar-link .bg-success {

            background: var(--oc-sage) !important;
        }


        .sidebar-link .bg-danger {

            background: var(--oc-terracotta) !important;
        }


        .sidebar-sublink {

            display: flex;

            align-items: center;

            padding: 9px 14px 9px 30px;

            margin-bottom: 4px;

            border-radius: 10px;

            text-decoration: none;

            color: #7a8a8e;

            font-weight: 500;

            font-size: 0.85rem;

            transition: all 0.2s ease;
        }


        .sidebar-sublink:hover {

            background: var(--oc-teal-light);

            color: var(--oc-teal);
        }


        .sidebar-sublink.active {

            background: var(--oc-teal-light);

            color: var(--oc-teal);

            font-weight: 600;
        }


        .sidebar-divider {

            border: none;

            border-top:
                1px solid rgba(28,43,51,0.08);

            margin: 14px 0;
        }


        /* =========================================================
           MAIN CONTENT
        ========================================================= */

        .main-content {

            margin-left: 260px;

            margin-top: 70px;

            padding: 28px;

            min-height: calc(100vh - 70px);
        }


        .page-wrapper {

            background: transparent;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 900px) {

            .sidebar {

                width: 220px;
            }

            .main-content {

                margin-left: 220px;
            }

            .topbar-search input {

                width: 180px;
            }
        }


        @media (max-width: 700px) {

            .topbar {

                padding: 0 15px;
            }

            .topbar-search {

                display: none;
            }

            .topbar-right {

                gap: 8px;
            }

            .sidebar {

                width: 220px;
            }

            .main-content {

                margin-left: 220px;

                padding: 18px;
            }
        }

    </style>

</head>


<body>


<!-- =========================================================
     TOP BAR
========================================================= -->

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


        <!-- =====================================================
             NOTIFICATION
        ====================================================== -->

        <div class="dropdown notification-wrapper">

            <a
                href="#"
                class="topbar-icon-btn"
                id="notificationDropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                title="Notifications"
            >

                <i class="bi bi-bell-fill"></i>


                @if(($totalNotifications ?? 0) > 0)

                    <span class="notification-badge">

                        {{ $totalNotifications > 99 ? '99+' : $totalNotifications }}

                    </span>

                @endif

            </a>


            <ul
                class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2"
                aria-labelledby="notificationDropdown"
            >

                <li>

                    <h6 class="dropdown-header fw-bold">

                        Notifications

                    </h6>

                </li>


                <li>

                    <a
                        class="dropdown-item d-flex justify-content-between align-items-center"
                        href="{{ route('appointments.index') }}"
                    >

                        <span>
                            <i class="bi bi-calendar-check me-2"></i>
                            Today's Appointments
                        </span>

                        <span class="badge bg-warning rounded-pill">

                            {{ $todayAppointments ?? 0 }}

                        </span>

                    </a>

                </li>


                <li>

                    <a
                        class="dropdown-item d-flex justify-content-between align-items-center"
                        href="{{ route('inventory.index') }}"
                    >

                        <span>
                            <i class="bi bi-box-seam me-2"></i>
                            Low Stock
                        </span>

                        <span class="badge bg-danger rounded-pill">

                            {{ $lowStock ?? 0 }}

                        </span>

                    </a>

                </li>


                <li>

                    <a
                        class="dropdown-item d-flex justify-content-between align-items-center"
                        href="{{ route('billing.index') }}"
                    >

                        <span>
                            <i class="bi bi-receipt me-2"></i>
                            Unpaid Billing
                        </span>

                        <span class="badge bg-danger rounded-pill">

                            {{ $unpaidBilling ?? 0 }}

                        </span>

                    </a>

                </li>

            </ul>

        </div>


        <!-- =====================================================
             USER DROPDOWN
        ====================================================== -->

        <div class="dropdown">

            <a
                href="#"
                class="topbar-avatar"
                id="userDropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >

                {{ strtoupper(substr(session('user_name', 'A'), 0, 1)) }}

            </a>


            <ul
                class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2"
                aria-labelledby="userDropdown"
            >

                <li>

                    <h6 class="dropdown-header">

                        {{ session('user_name', 'Admin') }}

                    </h6>

                </li>


                <li>

                    <a
                        class="dropdown-item"
                        href="{{ route('profile.edit') }}"
                    >

                        <i class="bi bi-person-gear me-2"></i>

                        Account Settings

                    </a>

                </li>


                <li>
                    <hr class="dropdown-divider">
                </li>


                <li>

                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="dropdown-item text-danger"
                        >

                            <i class="bi bi-box-arrow-right me-2"></i>

                            Logout

                        </button>

                    </form>

                </li>

            </ul>

        </div>

    </div>

</div>



<!-- =========================================================
     SIDEBAR
========================================================= -->

<div class="sidebar">


    <div class="sidebar-header">

        <i class="bi bi-eyeglasses me-2"></i>

        <span>OptiCare</span>

        <small>Clinic Menu</small>

    </div>


    <!-- DASHBOARD -->

    <a
        href="{{ route('dashboard') }}"
        class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
    >

        <i class="bi bi-speedometer2 me-2"></i>

        Dashboard

    </a>


    <!-- PATIENTS -->

    <a
        href="{{ route('patients.index') }}"
        class="sidebar-link {{ request()->routeIs('patients.*') ? 'active' : '' }}"
    >

        <i class="bi bi-person-lines-fill me-2"></i>

        Patients

    </a>


    <!-- APPOINTMENTS -->

    <a
        href="{{ route('appointments.index') }}"
        class="sidebar-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}"
    >

        <i class="bi bi-calendar-check me-2"></i>

        Appointments


        @if(($pendingAppointments ?? 0) > 0)

            <span class="badge bg-warning text-dark">

                {{ $pendingAppointments }}

            </span>

        @endif


        @if(($completedAppointments ?? 0) > 0)

            <span class="badge bg-success ms-1">

                {{ $completedAppointments }}

            </span>

        @endif

    </a>


    <!-- BILLING -->

    <a
        href="{{ route('billing.index') }}"
        class="sidebar-link {{ request()->routeIs('billing.*') ? 'active' : '' }}"
    >

        <i class="bi bi-receipt me-2"></i>

        Billing


        @if(($unpaidBilling ?? 0) > 0)

            <span class="badge bg-danger">

                {{ $unpaidBilling }}

            </span>

        @endif

    </a>


    <!-- INVENTORY -->

    <a
        href="{{ route('inventory.index') }}"
        class="sidebar-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}"
    >

        <i class="bi bi-box-seam me-2"></i>

        Inventory


        @if(($lowStock ?? 0) > 0)

            <span class="badge bg-danger">

                {{ $lowStock }}

            </span>

        @endif

    </a>


    <!-- REPORTS -->

    <a
        href="{{ route('reports.index') }}"
        class="sidebar-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"
    >

        <i class="bi bi-graph-up me-2"></i>

        Reports

    </a>


    <hr class="sidebar-divider">


    <!-- UTILITIES -->

    <a
        href="#utilitiesMenu"
        class="sidebar-link"
        data-bs-toggle="collapse"
        role="button"
        aria-expanded="{{ request()->routeIs(['users.*', 'archive.*', 'backup.*']) ? 'true' : 'false' }}"
    >

        <i class="bi bi-tools me-2"></i>

        Utilities

        <i class="bi bi-chevron-down ms-auto small"></i>

    </a>


    <div
        class="collapse {{ request()->routeIs(['users.*', 'archive.*', 'backup.*']) ? 'show' : '' }}"
        id="utilitiesMenu"
    >


        <!-- USER MANAGEMENT -->

        <a
            href="{{ route('users.index') }}"
            class="sidebar-sublink {{ request()->routeIs('users.*') ? 'active' : '' }}"
        >

            <i class="bi bi-people me-2"></i>

            User Management

        </a>


        <!-- ARCHIVE -->

        <a
            href="{{ route('archive.index') }}"
            class="sidebar-sublink {{ request()->routeIs('archive.*') ? 'active' : '' }}"
        >

            <i class="bi bi-archive me-2"></i>

            Archive

        </a>


        <!-- BACKUP -->

        <a
            href="{{ route('backup.index') }}"
            class="sidebar-sublink {{ request()->routeIs('backup.*') ? 'active' : '' }}"
        >

            <i class="bi bi-hdd-stack me-2"></i>

            Database Backup

        </a>

    </div>

</div>



<!-- =========================================================
     MAIN CONTENT
========================================================= -->

<div class="main-content">

    <div class="page-wrapper">

        @yield('content')

    </div>

</div>



<!-- =========================================================
     BOOTSTRAP JS
========================================================= -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


</body>

</html>