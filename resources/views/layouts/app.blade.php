<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>OptiCare Clinic Management System</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Fonts -->
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

        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: var(--oc-bg);
            color: var(--oc-ink);
            overflow-x: hidden;
        }

        .pagination svg,
        nav svg {
            width: 16px !important;
            height: 16px !important;
        }

        /* TOPBAR */
        .topbar {
            height: 70px;
            background: linear-gradient(90deg, var(--oc-teal), var(--oc-teal-dark));
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

        /* MOBILE MENU */
        .mobile-menu-btn {
            display: none;
            border: none;
            background: transparent;
            color: white;
            font-size: 1.35rem;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            cursor: pointer;
        }

        .mobile-menu-btn:hover {
            background: rgba(255, 255, 255, 0.12);
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
            color: rgba(255, 255, 255, 0.55);
            font-size: 0.85rem;
            pointer-events: none;
        }

        .topbar-search input {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: white;
            padding: 8px 16px 8px 38px;
            border-radius: 20px;
            width: 260px;
            font-size: 0.85rem;
            transition: 0.2s ease;
        }

        .topbar-search input::placeholder {
            color: rgba(255, 255, 255, 0.55);
        }

        .topbar-search input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.20);
            border-color: rgba(255, 255, 255, 0.30);
        }

        /* NOTIFICATIONS */
        .notification-wrapper {
            position: relative;
        }

        .topbar-icon-btn {
            color: rgba(255, 255, 255, 0.95);
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
            cursor: pointer;
        }

        .topbar-icon-btn:hover {
            background: rgba(255, 255, 255, 0.12);
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
            background: var(--oc-terracotta);
            color: white;
            font-size: 0.62rem;
            font-weight: 700;
            line-height: 1;
            border: 2px solid var(--oc-teal-dark);
        }

        .notification-shake {
            animation: notificationShake 0.8s ease-in-out;
        }

        @keyframes notificationShake {
            0% {
                transform: rotate(0deg);
            }

            15% {
                transform: rotate(15deg);
            }

            30% {
                transform: rotate(-15deg);
            }

            45% {
                transform: rotate(12deg);
            }

            60% {
                transform: rotate(-12deg);
            }

            75% {
                transform: rotate(7deg);
            }

            90% {
                transform: rotate(-7deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        /* USER AVATAR */
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
            cursor: pointer;
        }

        /* DROPDOWN */
        .dropdown-menu {
            border: none;
            border-radius: 14px;
            min-width: 250px;
            box-shadow: 0 12px 35px rgba(28, 43, 51, 0.14);
            z-index: 2000;
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

        /* NOTIFICATION ITEMS */
        .notification-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .notification-item-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .notification-item-left i {
            width: 20px;
            text-align: center;
        }

        .notification-count {
            min-width: 25px;
            text-align: center;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 8px;
        }

        .notification-count.warning {
            background: var(--oc-gold);
            color: white;
        }

        .notification-count.danger {
            background: var(--oc-terracotta);
            color: white;
        }

        .notification-count.success {
            background: var(--oc-sage);
            color: white;
        }

        /* SOUND BUTTON */
        .sound-status {
            font-size: 0.75rem;
            color: #718084;
            padding: 8px 15px;
        }

        .sound-enable-btn {
            width: calc(100% - 30px);
            margin: 5px 15px 12px;
            border: none;
            border-radius: 10px;
            padding: 8px 12px;
            background: var(--oc-teal);
            color: white;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .sound-enable-btn:hover {
            background: var(--oc-teal-dark);
        }

        .sound-enable-btn.enabled {
            background: var(--oc-sage);
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            height: calc(100vh - 70px);
            position: fixed;
            top: 70px;
            left: 0;
            padding: 24px 16px;
            background: white;
            box-shadow: 4px 0 20px rgba(28, 43, 51, 0.04);
            border-right: 1px solid rgba(28, 43, 51, 0.06);
            overflow-y: auto;
            z-index: 1000;
            transition: left 0.25s ease;
        }

        .sidebar-header {
            margin-bottom: 26px;
            padding: 16px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--oc-teal), var(--oc-teal-dark));
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
            box-shadow: 0 4px 12px rgba(27, 75, 79, 0.25);
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
            color: white !important;
        }

        .sidebar-link .bg-danger {
            background: var(--oc-terracotta) !important;
            color: white !important;
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
            border-top: 1px solid rgba(28, 43, 51, 0.08);
            margin: 14px 0;
        }

        /* MOBILE OVERLAY */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.35);
            z-index: 1090;
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 260px;
            margin-top: 70px;
            padding: 28px;
            width: calc(100% - 260px);
            min-height: calc(100vh - 70px);
            overflow-x: hidden;
        }

        .page-wrapper {
            width: 100%;
            max-width: 100%;
        }

        .table-responsive {
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .main-content img {
            max-width: 100%;
            height: auto;
        }

        .main-content input,
        .main-content select,
        .main-content textarea {
            max-width: 100%;
        }

        .main-content .card {
            max-width: 100%;
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 220px;
            }

            .main-content {
                margin-left: 220px;
                width: calc(100% - 220px);
                padding: 20px;
            }

            .topbar-search input {
                width: 180px;
            }
        }

        @media (max-width: 700px) {
            html,
            body {
                width: 100%;
                max-width: 100%;
                overflow-x: hidden;
            }

            .topbar {
                height: 64px;
                padding: 0 12px;
            }

            .topbar .logo {
                font-size: 1.1rem;
            }

            .mobile-menu-btn {
                display: flex;
            }

            .topbar-right {
                gap: 3px;
            }

            .topbar-search {
                display: none;
            }

            .topbar-icon-btn {
                width: 36px;
                height: 36px;
            }

            .topbar-avatar {
                width: 34px;
                height: 34px;
            }

            .sidebar {
                top: 64px;
                left: -270px;
                width: 260px;
                height: calc(100vh - 64px);
                padding: 20px 14px;
                z-index: 1100;
            }

            .sidebar.mobile-open {
                left: 0;
            }

            .sidebar-overlay.mobile-open {
                display: block;
            }

            .main-content {
                margin-left: 0 !important;
                margin-top: 64px;
                width: 100% !important;
                max-width: 100%;
                padding: 16px 12px;
                min-height: calc(100vh - 64px);
                overflow-x: hidden;
            }

            .page-wrapper {
                width: 100% !important;
                max-width: 100% !important;
                overflow-x: hidden;
            }

            .main-content .row {
                width: 100%;
                max-width: 100%;
                margin-left: 0;
                margin-right: 0;
            }

            .main-content .row > * {
                padding-left: 6px;
                padding-right: 6px;
            }

            .main-content .card,
            .hero-card,
            .welcome-card {
                width: 100% !important;
                max-width: 100% !important;
            }

            .table-responsive {
                width: 100%;
                max-width: 100%;
                overflow-x: auto;
            }

            .table {
                min-width: 650px;
            }

            .main-content .btn {
                max-width: 100%;
                white-space: nowrap;
            }

            .modal-dialog {
                margin: 10px;
            }

            .dropdown-menu {
                max-width: calc(100vw - 20px);
            }
        }

        @media (max-width: 400px) {
            .topbar {
                padding: 0 8px;
            }

            .topbar .logo {
                font-size: 1rem;
            }

            .topbar-icon-btn {
                width: 34px;
                height: 34px;
            }

            .topbar-avatar {
                width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }

            .main-content {
                padding: 12px 8px;
            }

            .sidebar {
                width: 250px;
                left: -260px;
            }
        }
    </style>
</head>

<body>

    <!-- NOTIFICATION SOUND -->
    <audio id="appointmentNotificationSound" preload="auto">
        <source src="{{ asset('storage/sounds/appointment-notification.mp3') }}" type="audio/mpeg">
    </audio>

    <!-- GLOBAL DATA -->
    @php
        $currentRole = session('user_role', '');
    @endphp

    <!-- TOPBAR -->
    <header class="topbar">
        <div class="d-flex align-items-center gap-2">

            <button type="button" class="mobile-menu-btn" id="mobileMenuButton" aria-label="Open menu">
                <i class="bi bi-list"></i>
            </button>

            <div class="logo">
                <i class="bi bi-eyeglasses me-2"></i>
                OptiCare
            </div>
        </div>

        <div class="topbar-right">

            <!-- SEARCH -->
            @if(in_array($currentRole, ['Admin', 'Staff']))
                @if(Route::has('search'))
                    <form action="{{ route('search') }}" method="GET" class="topbar-search">
                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            name="search"
                            placeholder="Search anything..."
                            value="{{ request('search') }}"
                            autocomplete="off"
                        >
                    </form>
                @endif
            @endif

            <!-- NOTIFICATIONS -->
            <div class="dropdown notification-wrapper">

                <a
                    href="#"
                    class="topbar-icon-btn"
                    id="notificationDropdown"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    title="Notifications"
                >
                    <i class="bi bi-bell-fill" id="notificationBell"></i>

                    <span
                        id="notificationBadge"
                        class="notification-badge"
                        style="{{ $totalNotifications > 0 ? '' : 'display:none;' }}"
                    >
                        {{ $totalNotifications > 99 ? '99+' : $totalNotifications }}
                    </span>
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

                    @if(Route::has('appointments.index'))

                        <li>
                            <a
                                class="dropdown-item notification-item"
                                href="{{ route('appointments.index') }}"
                            >
                                <span class="notification-item-left">
                                    <i
                                        class="bi bi-calendar-check"
                                        style="color: var(--oc-gold);"
                                    ></i>

                                    Pending Appointments
                                </span>

                                <span
                                    id="pendingAppointmentCount"
                                    class="notification-count warning"
                                >
                                    {{ $pendingAppointments }}
                                </span>
                            </a>
                        </li>

                        <li>
                            <a
                                class="dropdown-item notification-item"
                                href="{{ route('appointments.index') }}"
                            >
                                <span class="notification-item-left">
                                    <i
                                        class="bi bi-calendar-day"
                                        style="color: var(--oc-gold);"
                                    ></i>

                                    Today's Appointments
                                </span>

                                <span
                                    id="todayAppointmentCount"
                                    class="notification-count warning"
                                >
                                    {{ $todayAppointments }}
                                </span>
                            </a>
                        </li>

                    @endif

                    @if($currentRole === 'Admin' && Route::has('inventory.index'))

                        <li>
                            <a
                                class="dropdown-item notification-item"
                                href="{{ route('inventory.index') }}"
                            >
                                <span class="notification-item-left">
                                    <i
                                        class="bi bi-box-seam"
                                        style="color: var(--oc-terracotta);"
                                    ></i>

                                    Low Stock
                                </span>

                                <span
                                    class="notification-count danger"
                                    id="lowStockCount"
                                >
                                    {{ $lowStock }}
                                </span>
                            </a>
                        </li>

                    @endif

                    @if(Route::has('billing.index'))

                        <li>
                            <a
                                class="dropdown-item notification-item"
                                href="{{ route('billing.index') }}"
                            >
                                <span class="notification-item-left">
                                    <i
                                        class="bi bi-receipt"
                                        style="color: var(--oc-terracotta);"
                                    ></i>

                                    Unpaid Billing
                                </span>

                                <span
                                    id="unpaidBillingCount"
                                    class="notification-count danger"
                                >
                                    {{ $unpaidBilling }}
                                </span>
                            </a>
                        </li>

                    @endif

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>

                        <div class="sound-status" id="soundStatus">
                            <i class="bi bi-volume-up-fill me-1"></i>
                            Appointment sound is ready.
                        </div>

                        <button
                            type="button"
                            id="enableSoundButton"
                            class="sound-enable-btn"
                        >
                            <i class="bi bi-volume-up me-1"></i>
                            Enable Notification Sound
                        </button>

                    </li>
                </ul>
            </div>

            <!-- USER -->
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

                    @if(Route::has('profile.edit'))

                        <li>
                            <a
                                class="dropdown-item"
                                href="{{ route('profile.edit') }}"
                            >
                                <i class="bi bi-person-gear me-2"></i>
                                Account Settings
                            </a>
                        </li>

                    @endif

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    @if(Route::has('logout'))

                        <li>
                            <form action="{{ route('logout') }}" method="POST">
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

                    @endif

                </ul>
            </div>

        </div>
    </header>

    <!-- SIDEBAR OVERLAY -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-header">
            <i class="bi bi-eyeglasses me-2"></i>
            <span>OptiCare</span>
            <small>Clinic Menu</small>
        </div>

        <!-- ADMIN DASHBOARD -->
        @if($currentRole === 'Admin' && Route::has('dashboard'))

            <a
                href="{{ route('dashboard') }}"
                class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>

        @endif

        <!-- STAFF DASHBOARD -->
        @if($currentRole === 'Staff' && Route::has('staff.dashboard'))

            <a
                href="{{ route('staff.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}"
            >
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>

        @endif

        <!-- PATIENTS -->
        @if(Route::has('patients.index'))

            <a
                href="{{ route('patients.index') }}"
                class="sidebar-link {{ request()->routeIs('patients.*') ? 'active' : '' }}"
            >
                <i class="bi bi-person-lines-fill me-2"></i>
                Patients
            </a>

        @endif

        <!-- APPOINTMENTS -->
        @if(Route::has('appointments.index'))

            <a
                href="{{ route('appointments.index') }}"
                class="sidebar-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}"
            >
                <i class="bi bi-calendar-check me-2"></i>

                <span>Appointments</span>

                <div
                    class="ms-auto d-flex align-items-center gap-1"
                    id="appointmentSidebarBadges"
                >

                    @if($pendingAppointments > 0)

                        <span
                            class="badge bg-warning rounded-pill"
                            id="sidebarPendingBadge"
                            title="Pending Appointments"
                        >
                            {{ $pendingAppointments }}
                        </span>

                    @endif

                    @if($completedAppointments > 0)

                        <span
                            class="badge bg-success rounded-pill"
                            id="sidebarCompletedBadge"
                            title="Completed Appointments"
                        >
                            {{ $completedAppointments }}
                        </span>

                    @endif

                </div>
            </a>

        @endif

        <!-- BILLING -->
        @if(Route::has('billing.index'))

            <a
                href="{{ route('billing.index') }}"
                class="sidebar-link {{ request()->routeIs('billing.*') ? 'active' : '' }}"
            >
                <i class="bi bi-receipt me-2"></i>

                <span>Billing</span>

                @if($unpaidBilling > 0)
                    <span class="badge bg-danger">
                        {{ $unpaidBilling }}
                    </span>
                @endif

            </a>

        @endif

        <!-- INVENTORY -->
        @if($currentRole === 'Admin' && Route::has('inventory.index'))

            <a
                href="{{ route('inventory.index') }}"
                class="sidebar-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}"
            >
                <i class="bi bi-box-seam me-2"></i>

                <span>Inventory</span>

                @if($lowStock > 0)
                    <span class="badge bg-danger">
                        {{ $lowStock }}
                    </span>
                @endif

            </a>

        @endif

        <!-- REPORTS -->
        @if($currentRole === 'Admin' && Route::has('reports.index'))

            <a
                href="{{ route('reports.index') }}"
                class="sidebar-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"
            >
                <i class="bi bi-graph-up me-2"></i>
                Reports
            </a>

        @endif

        <!-- UTILITIES -->
        @if($currentRole === 'Admin')

            @if(
                Route::has('users.index') ||
                Route::has('archive.index') ||
                Route::has('backup.index')
            )

                <hr class="sidebar-divider">

                <a
                    href="#utilitiesMenu"
                    class="sidebar-link"
                    data-bs-toggle="collapse"
                    role="button"
                    aria-expanded="{{
                        request()->routeIs([
                            'users.*',
                            'archive.*',
                            'backup.*'
                        ]) ? 'true' : 'false'
                    }}"
                >
                    <i class="bi bi-tools me-2"></i>
                    Utilities
                    <i class="bi bi-chevron-down ms-auto small"></i>
                </a>

                <div
                    class="collapse {{
                        request()->routeIs([
                            'users.*',
                            'archive.*',
                            'backup.*'
                        ]) ? 'show' : ''
                    }}"
                    id="utilitiesMenu"
                >

                    @if(Route::has('users.index'))

                        <a
                            href="{{ route('users.index') }}"
                            class="sidebar-sublink {{ request()->routeIs('users.*') ? 'active' : '' }}"
                        >
                            <i class="bi bi-people me-2"></i>
                            User Management
                        </a>

                    @endif

                    @if(Route::has('archive.index'))

                        <a
                            href="{{ route('archive.index') }}"
                            class="sidebar-sublink {{ request()->routeIs('archive.*') ? 'active' : '' }}"
                        >
                            <i class="bi bi-archive me-2"></i>
                            Archive
                        </a>

                    @endif

                    @if(Route::has('backup.index'))

                        <a
                            href="{{ route('backup.index') }}"
                            class="sidebar-sublink {{ request()->routeIs('backup.*') ? 'active' : '' }}"
                        >
                            <i class="bi bi-hdd-stack me-2"></i>
                            Database Backup
                        </a>

                    @endif

                </div>

            @endif

        @endif

    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <div class="page-wrapper">
            @yield('content')
        </div>

    </main>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- OPTICARE JAVASCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const mobileMenuButton =
                document.getElementById('mobileMenuButton');

            const sidebar =
                document.getElementById('sidebar');

            const sidebarOverlay =
                document.getElementById('sidebarOverlay');

            const notificationBell =
                document.getElementById('notificationBell');

            const notificationBadge =
                document.getElementById('notificationBadge');

            const pendingAppointmentCount =
                document.getElementById('pendingAppointmentCount');

            const todayAppointmentCount =
                document.getElementById('todayAppointmentCount');

            const lowStockCount =
                document.getElementById('lowStockCount');

            const unpaidBillingCount =
                document.getElementById('unpaidBillingCount');

            const sound =
                document.getElementById('appointmentNotificationSound');

            const enableSoundButton =
                document.getElementById('enableSoundButton');

            const soundStatus =
                document.getElementById('soundStatus');

            let lastPendingAppointments =
                Number(@json($pendingAppointments));

            let lastNotificationTotal =
                Number(@json($totalNotifications));

            let soundEnabled =
                localStorage.getItem('opticare_sound_enabled') === 'true';


            /* SOUND UI */

            function updateSoundUI() {

                if (!enableSoundButton || !soundStatus) {
                    return;
                }

                if (soundEnabled) {

                    enableSoundButton.classList.add('enabled');

                    enableSoundButton.innerHTML =
                        '<i class="bi bi-volume-up-fill me-1"></i>' +
                        'Notification Sound Enabled';

                    soundStatus.innerHTML =
                        '<i class="bi bi-check-circle-fill me-1 text-success"></i>' +
                        'Appointment sound is enabled.';

                } else {

                    enableSoundButton.classList.remove('enabled');

                    enableSoundButton.innerHTML =
                        '<i class="bi bi-volume-up me-1"></i>' +
                        'Enable Notification Sound';

                    soundStatus.innerHTML =
                        '<i class="bi bi-volume-mute-fill me-1"></i>' +
                        'Click the button to enable appointment sound.';
                }
            }

            updateSoundUI();


            /* ENABLE SOUND */

            if (enableSoundButton && sound) {

                enableSoundButton.addEventListener(
                    'click',
                    async function () {

                        try {

                            sound.volume = 0;

                            await sound.play();

                            sound.pause();
                            sound.currentTime = 0;
                            sound.volume = 1;

                            soundEnabled = true;

                            localStorage.setItem(
                                'opticare_sound_enabled',
                                'true'
                            );

                            updateSoundUI();

                        } catch (error) {

                            console.error(
                                'Unable to enable notification sound:',
                                error
                            );

                            if (soundStatus) {

                                soundStatus.innerHTML =
                                    '<i class="bi bi-exclamation-triangle-fill text-danger me-1"></i>' +
                                    'Browser blocked the sound. Click again.';
                            }
                        }
                    }
                );
            }


            /* UNLOCK SOUND */

            document.addEventListener(
                'click',
                async function unlockSound() {

                    if (!soundEnabled || !sound) {
                        return;
                    }

                    try {

                        sound.volume = 0;

                        await sound.play();

                        sound.pause();
                        sound.currentTime = 0;
                        sound.volume = 1;

                    } catch (error) {

                        console.log(
                            'Waiting for user interaction to unlock sound.'
                        );
                    }

                },
                { once: true }
            );


            /* PLAY APPOINTMENT SOUND */

            async function playAppointmentSound() {

                if (!soundEnabled || !sound) {
                    return;
                }

                try {

                    sound.pause();
                    sound.currentTime = 0;
                    sound.volume = 1;

                    await sound.play();

                } catch (error) {

                    console.error(
                        'Appointment sound could not play:',
                        error
                    );

                    if (soundStatus) {

                        soundStatus.innerHTML =
                            '<i class="bi bi-exclamation-triangle-fill text-danger me-1"></i>' +
                            'Sound was blocked by the browser. Enable notification sound.';
                    }
                }
            }


            /* BROWSER NOTIFICATION */

            async function showBrowserNotification() {

                if (!('Notification' in window)) {
                    return;
                }

                try {

                    if (Notification.permission === 'default') {
                        await Notification.requestPermission();
                    }

                    if (Notification.permission === 'granted') {

                        const notification =
                            new Notification(
                                'OptiCare - New Appointment',
                                {
                                    body: 'A new online appointment has been booked.',
                                    icon: '{{ asset('favicon.ico') }}',
                                    tag: 'opticare-new-appointment',
                                    requireInteraction: true
                                }
                            );

                        notification.onclick = function () {

                            window.focus();

                            @if(Route::has('appointments.index'))

                                window.location.href =
                                    "{{ route('appointments.index') }}";

                            @endif
                        };
                    }

                } catch (error) {

                    console.error(
                        'Browser notification error:',
                        error
                    );
                }
            }


            /* ANIMATE BELL */

            function animateNotificationBell() {

                if (!notificationBell) {
                    return;
                }

                notificationBell.classList.remove(
                    'notification-shake'
                );

                void notificationBell.offsetWidth;

                notificationBell.classList.add(
                    'notification-shake'
                );

                setTimeout(function () {

                    notificationBell.classList.remove(
                        'notification-shake'
                    );

                }, 1000);
            }


            /* UPDATE NOTIFICATION BADGE */

            function updateNotificationBadge(
                pendingCount,
                todayCount,
                lowStockCountValue,
                unpaidCount
            ) {

                if (!notificationBadge) {
                    return;
                }

                const newTotal =
                    Number(pendingCount || 0) +
                    Number(todayCount || 0) +
                    Number(lowStockCountValue || 0) +
                    Number(unpaidCount || 0);

                if (newTotal > 0) {

                    notificationBadge.style.display = 'flex';

                    notificationBadge.textContent =
                        newTotal > 99 ? '99+' : newTotal;

                } else {

                    notificationBadge.style.display = 'none';
                }

                lastNotificationTotal = newTotal;
            }


            /* UPDATE PENDING COUNTERS */

            function updatePendingCounters(pendingCount) {

                pendingCount =
                    Number(pendingCount || 0);

                if (pendingAppointmentCount) {

                    pendingAppointmentCount.textContent =
                        pendingCount;
                }

                const sidebarContainer =
                    document.getElementById(
                        'appointmentSidebarBadges'
                    );

                if (!sidebarContainer) {
                    return;
                }

                let badge =
                    document.getElementById(
                        'sidebarPendingBadge'
                    );

                if (pendingCount > 0) {

                    if (!badge) {

                        badge =
                            document.createElement('span');

                        badge.id =
                            'sidebarPendingBadge';

                        badge.className =
                            'badge bg-warning rounded-pill';

                        badge.title =
                            'Pending Appointments';

                        sidebarContainer.prepend(badge);
                    }

                    badge.textContent =
                        pendingCount;

                } else {

                    if (badge) {
                        badge.remove();
                    }
                }
            }


            /* GET COUNTER VALUE */

            function getCounterValue(
                documentHTML,
                selector
            ) {

                const element =
                    documentHTML.querySelector(selector);

                if (!element) {
                    return 0;
                }

                return (
                    parseInt(
                        element.textContent.trim(),
                        10
                    ) || 0
                );
            }


            /* CHECK NEW APPOINTMENTS */

            async function checkForNewAppointments() {

                @if(!Route::has('appointments.index'))
                    return;
                @endif

                try {

                    const response =
                        await fetch(
                            "{{ route('appointments.index') }}",
                            {
                                method: 'GET',

                                headers: {
                                    'X-Requested-With':
                                        'XMLHttpRequest',

                                    'Accept':
                                        'text/html'
                                },

                                cache: 'no-store'
                            }
                        );

                    if (!response.ok) {
                        return;
                    }

                    const html =
                        await response.text();

                    const parser =
                        new DOMParser();

                    const documentHTML =
                        parser.parseFromString(
                            html,
                            'text/html'
                        );


                    /* PENDING */

                    let currentPending =
                        getCounterValue(
                            documentHTML,
                            '#pendingAppointmentCount'
                        );

                    if (
                        currentPending === 0 &&
                        documentHTML.querySelector(
                            '#sidebarPendingBadge'
                        )
                    ) {

                        currentPending =
                            getCounterValue(
                                documentHTML,
                                '#sidebarPendingBadge'
                            );
                    }


                    /* TODAY */

                    const currentToday =
                        getCounterValue(
                            documentHTML,
                            '#todayAppointmentCount'
                        );


                    /* LOW STOCK */

                    const currentLowStock =
                        getCounterValue(
                            documentHTML,
                            '#lowStockCount'
                        );


                    /* UNPAID */

                    const currentUnpaid =
                        getCounterValue(
                            documentHTML,
                            '#unpaidBillingCount'
                        );


                    updatePendingCounters(
                        currentPending
                    );


                    if (todayAppointmentCount) {

                        todayAppointmentCount.textContent =
                            currentToday;
                    }


                    if (lowStockCount) {

                        lowStockCount.textContent =
                            currentLowStock;
                    }


                    if (unpaidBillingCount) {

                        unpaidBillingCount.textContent =
                            currentUnpaid;
                    }


                    /* NEW APPOINTMENT */

                    if (
                        currentPending >
                        lastPendingAppointments
                    ) {

                        const numberOfNewAppointments =
                            currentPending -
                            lastPendingAppointments;

                        await playAppointmentSound();

                        animateNotificationBell();

                        await showBrowserNotification();

                        showAppointmentToast(
                            numberOfNewAppointments
                        );
                    }


                    lastPendingAppointments =
                        currentPending;


                    updateNotificationBadge(
                        currentPending,
                        currentToday,
                        currentLowStock,
                        currentUnpaid
                    );

                } catch (error) {

                    console.error(
                        'Appointment notification check failed:',
                        error
                    );
                }
            }


            /* TOAST */

            function showAppointmentToast(count = 1) {

                const existingToast =
                    document.getElementById(
                        'appointmentToast'
                    );

                if (existingToast) {
                    existingToast.remove();
                }

                const toast =
                    document.createElement('div');

                toast.id =
                    'appointmentToast';

                toast.style.position =
                    'fixed';

                toast.style.right =
                    '20px';

                toast.style.bottom =
                    '20px';

                toast.style.zIndex =
                    '99999';

                toast.style.background =
                    '#ffffff';

                toast.style.color =
                    '#1C2B33';

                toast.style.borderRadius =
                    '14px';

                toast.style.padding =
                    '16px 20px';

                toast.style.minWidth =
                    '300px';

                toast.style.maxWidth =
                    '380px';

                toast.style.boxShadow =
                    '0 10px 35px rgba(0,0,0,0.18)';

                toast.style.borderLeft =
                    '5px solid #C98A3E';


                const message =
                    count === 1
                        ? 'A new online appointment has been booked.'
                        : `${count} new online appointments have been booked.`;


                toast.innerHTML = `
                    <div style="
                        display:flex;
                        align-items:center;
                        gap:12px;
                    ">

                        <div style="
                            width:42px;
                            height:42px;
                            border-radius:50%;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            background:#E8F0EF;
                            color:#1B4B4F;
                            font-size:20px;
                        ">

                            <i class="bi bi-calendar-check-fill"></i>

                        </div>

                        <div>

                            <strong style="
                                display:block;
                                color:#1B4B4F;
                                margin-bottom:3px;
                            ">
                                OptiCare - New Appointment
                            </strong>

                            <span style="
                                font-size:13px;
                                color:#68777B;
                            ">
                                ${message}
                            </span>

                        </div>

                    </div>
                `;


                document.body.appendChild(toast);


                setTimeout(function () {

                    toast.style.opacity =
                        '0';

                    toast.style.transform =
                        'translateY(10px)';

                    toast.style.transition =
                        '0.3s ease';


                    setTimeout(function () {

                        toast.remove();

                    }, 300);

                }, 6000);
            }


            /* SIDEBAR */

            function openSidebar() {

                if (!sidebar || !sidebarOverlay) {
                    return;
                }

                sidebar.classList.add(
                    'mobile-open'
                );

                sidebarOverlay.classList.add(
                    'mobile-open'
                );
            }


            function closeSidebar() {

                if (!sidebar || !sidebarOverlay) {
                    return;
                }

                sidebar.classList.remove(
                    'mobile-open'
                );

                sidebarOverlay.classList.remove(
                    'mobile-open'
                );
            }


            /* MOBILE MENU BUTTON */

            if (mobileMenuButton) {

                mobileMenuButton.addEventListener(
                    'click',
                    function () {

                        if (
                            sidebar &&
                            sidebar.classList.contains(
                                'mobile-open'
                            )
                        ) {

                            closeSidebar();

                        } else {

                            openSidebar();
                        }
                    }
                );
            }


            /* OVERLAY */

            if (sidebarOverlay) {

                sidebarOverlay.addEventListener(
                    'click',
                    closeSidebar
                );
            }


            /* SIDEBAR LINKS */

            document
                .querySelectorAll('.sidebar a')
                .forEach(function (link) {

                    link.addEventListener(
                        'click',
                        function () {

                            if (
                                window.innerWidth <= 700
                            ) {

                                closeSidebar();
                            }
                        }
                    );
                });


            /* START NOTIFICATION CHECK */

            @if(in_array($currentRole, ['Admin', 'Staff']))

                setTimeout(function () {

                    checkForNewAppointments();

                }, 5000);


                setInterval(function () {

                    checkForNewAppointments();

                }, 5000);

            @endif

        });
    </script>

</body>
</html>