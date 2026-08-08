<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>OptiCare Clinic Management System</title>


    <!-- =====================================================
         BOOTSTRAP
    ====================================================== -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- =====================================================
         BOOTSTRAP ICONS
    ====================================================== -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
        rel="stylesheet"
    >


    <!-- =====================================================
         FONTS
    ====================================================== -->

    <link rel="preconnect" href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=fraunces:500,600,700|inter:400,500,600,700"
        rel="stylesheet"
    >


    <!-- =====================================================
         CUSTOM CSS
    ====================================================== -->

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


        /* =====================================================
           PAGINATION
        ====================================================== */

        .pagination svg,
        nav svg {

            width: 16px !important;
            height: 16px !important;
        }


        /* =====================================================
           TOPBAR
        ====================================================== */

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


        /* =====================================================
           MOBILE MENU
        ====================================================== */

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

            background:
                rgba(255,255,255,0.12);
        }


        /* =====================================================
           SEARCH
        ====================================================== */

        .topbar-search {

            position: relative;
        }


        .topbar-search i {

            position: absolute;

            left: 16px;
            top: 50%;

            transform:
                translateY(-50%);

            color:
                rgba(255,255,255,0.55);

            font-size: 0.85rem;

            pointer-events: none;
        }


        .topbar-search input {

            background:
                rgba(255,255,255,0.12);

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

            color:
                rgba(255,255,255,0.55);
        }


        .topbar-search input:focus {

            outline: none;

            background:
                rgba(255,255,255,0.20);

            border-color:
                rgba(255,255,255,0.30);
        }


        /* =====================================================
           NOTIFICATIONS
        ====================================================== */

        .notification-wrapper {

            position: relative;
        }


        .topbar-icon-btn {

            color:
                rgba(255,255,255,0.95);

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

            border:
                2px solid var(--oc-teal-dark);
        }


        /* =====================================================
           NOTIFICATION SHAKE
        ====================================================== */

        .notification-shake {

            animation:
                notificationShake 0.8s ease-in-out;
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


        /* =====================================================
           USER AVATAR
        ====================================================== */

        .topbar-avatar {

            width: 36px;
            height: 36px;

            border-radius: 50%;

            background:
                var(--oc-gold);

            color:
                var(--oc-teal-dark);

            display: flex;

            align-items: center;
            justify-content: center;

            font-weight: 700;

            font-size: 0.9rem;

            text-decoration: none;

            cursor: pointer;
        }


        /* =====================================================
           DROPDOWN
        ====================================================== */

        .dropdown-menu {

            border: none;

            border-radius: 14px;

            min-width: 250px;

            box-shadow:
                0 12px 35px rgba(28,43,51,0.14);

            z-index: 2000;
        }


        .dropdown-header {

            font-family:
                'Fraunces', serif;

            color:
                var(--oc-teal);
        }


        .dropdown-item {

            padding: 10px 15px;
        }


        .dropdown-item:hover {

            background:
                var(--oc-teal-light);

            color:
                var(--oc-teal);
        }


        .dropdown-item:active {

            background:
                var(--oc-teal-light);

            color:
                var(--oc-ink);
        }


        /* =====================================================
           NOTIFICATION ITEMS
        ====================================================== */

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

            background:
                var(--oc-gold);

            color: white;
        }


        .notification-count.danger {

            background:
                var(--oc-terracotta);

            color: white;
        }


        .notification-count.success {

            background:
                var(--oc-sage);

            color: white;
        }


        /* =====================================================
           SIDEBAR
        ====================================================== */

        .sidebar {

            width: 260px;

            height:
                calc(100vh - 70px);

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

            transition:
                left 0.25s ease;
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

            font-family:
                'Fraunces', serif;

            font-weight: 600;

            font-size: 1.05rem;

            text-align: center;
        }


        .sidebar-header small {

            display: block;

            font-family:
                'Inter', sans-serif;

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

            transition:
                all 0.2s ease;
        }


        .sidebar-link i {

            font-size: 1rem;

            width: 22px;
        }


        .sidebar-link:hover {

            background:
                var(--oc-teal-light);

            color:
                var(--oc-teal);
        }


        .sidebar-link.active {

            background:
                var(--oc-teal);

            color: white;

            box-shadow:
                0 4px 12px
                rgba(27,75,79,0.25);
        }


        .sidebar-link .badge {

            font-size: 0.68rem;

            font-weight: 600;

            margin-left: auto;
        }


        .sidebar-link .bg-warning {

            background:
                var(--oc-gold) !important;

            color: white !important;
        }


        .sidebar-link .bg-success {

            background:
                var(--oc-sage) !important;

            color: white !important;
        }


        .sidebar-link .bg-danger {

            background:
                var(--oc-terracotta) !important;

            color: white !important;
        }


        .sidebar-sublink {

            display: flex;

            align-items: center;

            padding:
                9px
                14px
                9px
                30px;

            margin-bottom: 4px;

            border-radius: 10px;

            text-decoration: none;

            color: #7a8a8e;

            font-weight: 500;

            font-size: 0.85rem;

            transition:
                all 0.2s ease;
        }


        .sidebar-sublink:hover {

            background:
                var(--oc-teal-light);

            color:
                var(--oc-teal);
        }


        .sidebar-sublink.active {

            background:
                var(--oc-teal-light);

            color:
                var(--oc-teal);

            font-weight: 600;
        }


        .sidebar-divider {

            border: none;

            border-top:
                1px solid rgba(28,43,51,0.08);

            margin: 14px 0;
        }


        /* =====================================================
           MOBILE OVERLAY
        ====================================================== */

        .sidebar-overlay {

            display: none;

            position: fixed;

            top: 0;
            left: 0;

            width: 100%;
            height: 100%;

            background:
                rgba(0,0,0,0.35);

            z-index: 1090;
        }


        /* =====================================================
           MAIN CONTENT
        ====================================================== */

        .main-content {

            margin-left: 260px;

            margin-top: 70px;

            padding: 28px;

            width:
                calc(100% - 260px);

            min-height:
                calc(100vh - 70px);

            overflow-x: hidden;
        }


        .page-wrapper {

            width: 100%;

            max-width: 100%;
        }


        /* =====================================================
           RESPONSIVE TABLE
        ====================================================== */

        .table-responsive {

            width: 100%;

            max-width: 100%;

            overflow-x: auto;

            -webkit-overflow-scrolling: touch;
        }


        /* =====================================================
           IMAGES
        ====================================================== */

        .main-content img {

            max-width: 100%;

            height: auto;
        }


        /* =====================================================
           FORMS
        ====================================================== */

        .main-content input,
        .main-content select,
        .main-content textarea {

            max-width: 100%;
        }


        /* =====================================================
           CARDS
        ====================================================== */

        .main-content .card {

            max-width: 100%;
        }


        /* =====================================================
           900px
        ====================================================== */

        @media (max-width: 900px) {

            .sidebar {

                width: 220px;
            }


            .main-content {

                margin-left: 220px;

                width:
                    calc(100% - 220px);

                padding: 20px;
            }


            .topbar-search input {

                width: 180px;
            }
        }


        /* =====================================================
           MOBILE 700px
        ====================================================== */

        @media (max-width: 700px) {

            html,
            body {

                width: 100%;

                max-width: 100%;

                overflow-x: hidden;
            }


            /* TOPBAR */

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


            /* SIDEBAR */

            .sidebar {

                top: 64px;

                left: -270px;

                width: 260px;

                height:
                    calc(100vh - 64px);

                padding: 20px 14px;

                z-index: 1100;
            }


            .sidebar.mobile-open {

                left: 0;
            }


            /* OVERLAY */

            .sidebar-overlay.mobile-open {

                display: block;
            }


            /* MAIN */

            .main-content {

                margin-left: 0 !important;

                margin-top: 64px;

                width: 100% !important;

                max-width: 100%;

                padding: 16px 12px;

                min-height:
                    calc(100vh - 64px);

                overflow-x: hidden;
            }


            .page-wrapper {

                width: 100% !important;

                max-width: 100% !important;

                overflow-x: hidden;
            }


            /* BOOTSTRAP ROW */

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


            /* CARDS */

            .main-content .card {

                width: 100% !important;

                max-width: 100% !important;
            }


            /* HERO */

            .hero-card,
            .welcome-card {

                width: 100% !important;

                max-width: 100% !important;
            }


            /* TABLE */

            .table-responsive {

                width: 100%;

                max-width: 100%;

                overflow-x: auto;
            }


            .table {

                min-width: 650px;
            }


            /* BUTTONS */

            .main-content .btn {

                max-width: 100%;

                white-space: nowrap;
            }


            /* MODALS */

            .modal-dialog {

                margin: 10px;
            }


            /* DROPDOWN */

            .dropdown-menu {

                max-width:
                    calc(100vw - 20px);
            }
        }


        /* =====================================================
           VERY SMALL PHONES
        ====================================================== */

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

                padding:
                    12px 8px;
            }


            .sidebar {

                width: 250px;

                left: -260px;
            }
        }

    </style>

</head>


<body>


@php

    /*
    |--------------------------------------------------------------------------
    | USER ROLE
    |--------------------------------------------------------------------------
    */

    $currentRole = session('user_role', '');


    /*
    |--------------------------------------------------------------------------
    | GLOBAL NOTIFICATION COUNTS
    |--------------------------------------------------------------------------
    */

    $pendingAppointments = 0;

    $completedAppointments = 0;

    $todayAppointments = 0;

    $unpaidBilling = 0;

    $lowStock = 0;


    /*
    |--------------------------------------------------------------------------
    | APPOINTMENTS
    |--------------------------------------------------------------------------
    */

    try {

        if (
            \Illuminate\Support\Facades\Schema::hasTable(
                'appointments'
            )
        ) {

            $appointmentQuery =
                \Illuminate\Support\Facades\DB::table(
                    'appointments'
                );


            /*
            |--------------------------------------------------------------------------
            | STATUS COUNTS
            |--------------------------------------------------------------------------
            */

            if (
                \Illuminate\Support\Facades\Schema::hasColumn(
                    'appointments',
                    'status'
                )
            ) {

                $pendingAppointments =
                    (clone $appointmentQuery)
                    ->whereRaw(
                        'LOWER(status) = ?',
                        ['pending']
                    )
                    ->count();


                $completedAppointments =
                    (clone $appointmentQuery)
                    ->whereRaw(
                        'LOWER(status) = ?',
                        ['completed']
                    )
                    ->count();
            }


            /*
            |--------------------------------------------------------------------------
            | TODAY'S APPOINTMENTS
            |--------------------------------------------------------------------------
            */

            if (
                \Illuminate\Support\Facades\Schema::hasColumn(
                    'appointments',
                    'appointment_date'
                )
            ) {

                $todayAppointments =
                    (clone $appointmentQuery)
                    ->whereDate(
                        'appointment_date',
                        now()->toDateString()
                    )
                    ->count();
            }

        }

    } catch (\Throwable $e) {

        $pendingAppointments = 0;

        $completedAppointments = 0;

        $todayAppointments = 0;
    }


    /*
    |--------------------------------------------------------------------------
    | BILLING
    |--------------------------------------------------------------------------
    */

    try {

        if (
            \Illuminate\Support\Facades\Schema::hasTable(
                'billings'
            )
        ) {

            $billingQuery =
                \Illuminate\Support\Facades\DB::table(
                    'billings'
                );


            if (
                \Illuminate\Support\Facades\Schema::hasColumn(
                    'billings',
                    'payment_status'
                )
            ) {

                $unpaidBilling =
                    (clone $billingQuery)
                    ->whereRaw(
                        'LOWER(payment_status) = ?',
                        ['unpaid']
                    )
                    ->count();

            } elseif (
                \Illuminate\Support\Facades\Schema::hasColumn(
                    'billings',
                    'status'
                )
            ) {

                $unpaidBilling =
                    (clone $billingQuery)
                    ->whereRaw(
                        'LOWER(status) = ?',
                        ['unpaid']
                    )
                    ->count();
            }

        }

    } catch (\Throwable $e) {

        $unpaidBilling = 0;
    }


    /*
    |--------------------------------------------------------------------------
    | INVENTORY
    |--------------------------------------------------------------------------
    */

    try {

        if (
            \Illuminate\Support\Facades\Schema::hasTable(
                'inventories'
            )
        ) {

            $inventoryQuery =
                \Illuminate\Support\Facades\DB::table(
                    'inventories'
                );


            if (
                \Illuminate\Support\Facades\Schema::hasColumn(
                    'inventories',
                    'stock'
                )
            ) {

                $lowStock =
                    (clone $inventoryQuery)
                    ->where(
                        'stock',
                        '<=',
                        10
                    )
                    ->count();

            } elseif (
                \Illuminate\Support\Facades\Schema::hasColumn(
                    'inventories',
                    'quantity'
                )
            ) {

                $lowStock =
                    (clone $inventoryQuery)
                    ->where(
                        'quantity',
                        '<=',
                        10
                    )
                    ->count();
            }
        }

    } catch (\Throwable $e) {

        $lowStock = 0;
    }


    /*
    |--------------------------------------------------------------------------
    | TOTAL NOTIFICATIONS
    |--------------------------------------------------------------------------
    */

    $totalNotifications =
        $todayAppointments
        + $lowStock
        + $unpaidBilling;

@endphp



<!-- =====================================================
     TOPBAR
====================================================== -->

<header class="topbar">


    <div class="d-flex align-items-center gap-2">


        <!-- MOBILE MENU -->

        <button
            type="button"
            class="mobile-menu-btn"
            id="mobileMenuButton"
            aria-label="Open menu"
        >

            <i class="bi bi-list"></i>

        </button>


        <!-- LOGO -->

        <div class="logo">

            <i class="bi bi-eyeglasses me-2"></i>

            OptiCare

        </div>

    </div>



    <div class="topbar-right">


        <!-- =================================================
             SEARCH
        ================================================== -->

        @if(in_array($currentRole, ['Admin', 'Staff']))

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
                    autocomplete="off"
                >

            </form>

        @endif



        <!-- =================================================
             NOTIFICATIONS
        ================================================== -->

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


                @if($totalNotifications > 0)

                    <span class="notification-badge">

                        {{
                            $totalNotifications > 99
                            ? '99+'
                            : $totalNotifications
                        }}

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


                <!-- TODAY'S APPOINTMENTS -->

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

                            Today's Appointments

                        </span>


                        <span class="notification-count warning">

                            {{ $todayAppointments }}

                        </span>

                    </a>

                </li>


                <!-- LOW STOCK -->

                @if($currentRole === 'Admin')

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


                            <span class="notification-count danger">

                                {{ $lowStock }}

                            </span>

                        </a>

                    </li>

                @endif


                <!-- UNPAID BILLING -->

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


                        <span class="notification-count danger">

                            {{ $unpaidBilling }}

                        </span>

                    </a>

                </li>

            </ul>

        </div>



        <!-- =================================================
             USER
        ================================================== -->

        <div class="dropdown">

            <a
                href="#"
                class="topbar-avatar"
                id="userDropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >

                {{
                    strtoupper(
                        substr(
                            session('user_name', 'A'),
                            0,
                            1
                        )
                    )
                }}

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

                            <i
                                class="bi bi-box-arrow-right me-2"
                            ></i>

                            Logout

                        </button>

                    </form>

                </li>

            </ul>

        </div>

    </div>

</header>



<!-- =====================================================
     SIDEBAR OVERLAY
====================================================== -->

<div
    class="sidebar-overlay"
    id="sidebarOverlay"
></div>



<!-- =====================================================
     SIDEBAR
====================================================== -->

<aside
    class="sidebar"
    id="sidebar"
>


    <!-- SIDEBAR HEADER -->

    <div class="sidebar-header">

        <i class="bi bi-eyeglasses me-2"></i>

        <span>OptiCare</span>

        <small>Clinic Menu</small>

    </div>



    <!-- =================================================
         ADMIN DASHBOARD
    ================================================== -->

    @if($currentRole === 'Admin')

        <a
            href="{{ route('dashboard') }}"
            class="sidebar-link
            {{ request()->routeIs('dashboard') ? 'active' : '' }}"
        >

            <i class="bi bi-speedometer2 me-2"></i>

            Dashboard

        </a>

    @endif



    <!-- =================================================
         STAFF DASHBOARD
    ================================================== -->

    @if($currentRole === 'Staff')

        <a
            href="{{ route('staff.dashboard') }}"
            class="sidebar-link
            {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}"
        >

            <i class="bi bi-speedometer2 me-2"></i>

            Dashboard

        </a>

    @endif



    <!-- =================================================
         PATIENTS
    ================================================== -->

    <a
        href="{{ route('patients.index') }}"
        class="sidebar-link
        {{ request()->routeIs('patients.*') ? 'active' : '' }}"
    >

        <i class="bi bi-person-lines-fill me-2"></i>

        Patients

    </a>



    <!-- =================================================
         APPOINTMENTS
    ================================================== -->

    <a
        href="{{ route('appointments.index') }}"
        class="sidebar-link
        {{ request()->routeIs('appointments.*') ? 'active' : '' }}"
    >

        <i class="bi bi-calendar-check me-2"></i>

        <span>Appointments</span>


        <div class="ms-auto d-flex align-items-center gap-1">

            @if(($pendingAppointments ?? 0) > 0)

                <span
                    class="badge bg-warning rounded-pill"
                    title="Pending Appointments"
                >

                    {{ $pendingAppointments }}

                </span>

            @endif


            @if(($completedAppointments ?? 0) > 0)

                <span
                    class="badge bg-success rounded-pill"
                    title="Completed Appointments"
                >

                    {{ $completedAppointments }}

                </span>

            @endif

        </div>

    </a>



    <!-- =================================================
         BILLING
    ================================================== -->

    <a
        href="{{ route('billing.index') }}"
        class="sidebar-link
        {{ request()->routeIs('billing.*') ? 'active' : '' }}"
    >

        <i class="bi bi-receipt me-2"></i>

        <span>Billing</span>


        @if($unpaidBilling > 0)

            <span class="badge bg-danger">

                {{ $unpaidBilling }}

            </span>

        @endif

    </a>



    <!-- =================================================
         INVENTORY - ADMIN ONLY
    ================================================== -->

    @if($currentRole === 'Admin')

        <a
            href="{{ route('inventory.index') }}"
            class="sidebar-link
            {{ request()->routeIs('inventory.*') ? 'active' : '' }}"
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



    <!-- =================================================
         REPORTS - ADMIN ONLY
    ================================================== -->

    @if($currentRole === 'Admin')

        <a
            href="{{ route('reports.index') }}"
            class="sidebar-link
            {{ request()->routeIs('reports.*') ? 'active' : '' }}"
        >

            <i class="bi bi-graph-up me-2"></i>

            Reports

        </a>

    @endif



    <!-- =================================================
         UTILITIES - ADMIN ONLY
    ================================================== -->

    @if($currentRole === 'Admin')

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
                ])
                ? 'true'
                : 'false'
            }}"
        >

            <i class="bi bi-tools me-2"></i>

            Utilities

            <i
                class="bi bi-chevron-down ms-auto small"
            ></i>

        </a>


        <div
            class="collapse
            {{
                request()->routeIs([
                    'users.*',
                    'archive.*',
                    'backup.*'
                ])
                ? 'show'
                : ''
            }}"
            id="utilitiesMenu"
        >


            <!-- USER MANAGEMENT -->

            <a
                href="{{ route('users.index') }}"
                class="sidebar-sublink
                {{ request()->routeIs('users.*') ? 'active' : '' }}"
            >

                <i class="bi bi-people me-2"></i>

                User Management

            </a>


            <!-- ARCHIVE -->

            <a
                href="{{ route('archive.index') }}"
                class="sidebar-sublink
                {{ request()->routeIs('archive.*') ? 'active' : '' }}"
            >

                <i class="bi bi-archive me-2"></i>

                Archive

            </a>


            <!-- BACKUP -->

            <a
                href="{{ route('backup.index') }}"
                class="sidebar-sublink
                {{ request()->routeIs('backup.*') ? 'active' : '' }}"
            >

                <i class="bi bi-hdd-stack me-2"></i>

                Database Backup

            </a>

        </div>

    @endif

</aside>



<!-- =====================================================
     MAIN CONTENT
====================================================== -->

<main class="main-content">

    <div class="page-wrapper">

        @yield('content')

    </div>

</main>



<!-- =====================================================
     BOOTSTRAP JS
====================================================== -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>



<!-- =====================================================
     MOBILE SIDEBAR SCRIPT
====================================================== -->

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const sidebar =
            document.getElementById('sidebar');

        const menuButton =
            document.getElementById(
                'mobileMenuButton'
            );

        const overlay =
            document.getElementById(
                'sidebarOverlay'
            );


        function openSidebar() {

            if (sidebar) {

                sidebar.classList.add(
                    'mobile-open'
                );
            }


            if (overlay) {

                overlay.classList.add(
                    'mobile-open'
                );
            }


            document.body.style.overflow =
                'hidden';
        }


        function closeSidebar() {

            if (sidebar) {

                sidebar.classList.remove(
                    'mobile-open'
                );
            }


            if (overlay) {

                overlay.classList.remove(
                    'mobile-open'
                );
            }


            document.body.style.overflow =
                '';
        }


        if (menuButton) {

            menuButton.addEventListener(
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


        if (overlay) {

            overlay.addEventListener(
                'click',
                closeSidebar
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CLOSE SIDEBAR AFTER LINK CLICK
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '.sidebar a'
            )
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


        /*
        |--------------------------------------------------------------------------
        | RESET ON DESKTOP
        |--------------------------------------------------------------------------
        */

        window.addEventListener(
            'resize',
            function () {

                if (
                    window.innerWidth > 700
                ) {

                    closeSidebar();
                }

            }
        );

    }
);

</script>



<!-- =====================================================
     ONLINE APPOINTMENT NOTIFICATION
====================================================== -->

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | STORAGE KEY
        |--------------------------------------------------------------------------
        */

        const storageKey =
            'opticare_last_online_appointment';


        /*
        |--------------------------------------------------------------------------
        | LAST KNOWN APPOINTMENT
        |--------------------------------------------------------------------------
        */

        let lastAppointmentId =
            localStorage.getItem(
                storageKey
            );


        /*
        |--------------------------------------------------------------------------
        | AUDIO
        |--------------------------------------------------------------------------
        */

        let audioContext = null;

        let soundEnabled = false;


        /*
        |--------------------------------------------------------------------------
        | ENABLE SOUND
        |--------------------------------------------------------------------------
        */

        function enableNotificationSound() {

            if (soundEnabled) {

                return;
            }


            try {

                const AudioContext =
                    window.AudioContext ||
                    window.webkitAudioContext;


                if (!AudioContext) {

                    return;
                }


                audioContext =
                    new AudioContext();


                if (
                    audioContext.state ===
                    'suspended'
                ) {

                    audioContext.resume();

                }


                soundEnabled = true;


                console.log(
                    'OptiCare notification sound enabled.'
                );

            } catch (error) {

                console.log(
                    'Unable to enable notification sound.',
                    error
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | USER INTERACTION ENABLES AUDIO
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            enableNotificationSound,
            {
                once: true
            }
        );


        document.addEventListener(
            'keydown',
            enableNotificationSound,
            {
                once: true
            }
        );


        /*
        |--------------------------------------------------------------------------
        | PLAY NOTIFICATION SOUND
        |--------------------------------------------------------------------------
        */

        function playNotificationSound() {

            if (!audioContext) {

                return;
            }


            try {

                if (
                    audioContext.state ===
                    'suspended'
                ) {

                    audioContext.resume();

                }


                const oscillator =
                    audioContext.createOscillator();


                const gainNode =
                    audioContext.createGain();


                oscillator.type =
                    'sine';


                /*
                |--------------------------------------------------------------------------
                | FIRST TONE
                |--------------------------------------------------------------------------
                */

                oscillator.frequency.setValueAtTime(
                    880,
                    audioContext.currentTime
                );


                /*
                |--------------------------------------------------------------------------
                | SECOND TONE
                |--------------------------------------------------------------------------
                */

                oscillator.frequency.setValueAtTime(
                    660,
                    audioContext.currentTime + 0.15
                );


                /*
                |--------------------------------------------------------------------------
                | VOLUME
                |--------------------------------------------------------------------------
                */

                gainNode.gain.setValueAtTime(
                    0.0001,
                    audioContext.currentTime
                );


                gainNode.gain.exponentialRampToValueAtTime(
                    0.25,
                    audioContext.currentTime + 0.02
                );


                gainNode.gain.exponentialRampToValueAtTime(
                    0.0001,
                    audioContext.currentTime + 0.45
                );


                oscillator.connect(
                    gainNode
                );


                gainNode.connect(
                    audioContext.destination
                );


                oscillator.start();


                oscillator.stop(
                    audioContext.currentTime + 0.45
                );

            } catch (error) {

                console.log(
                    'Notification sound error:',
                    error
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | BROWSER NOTIFICATION
        |--------------------------------------------------------------------------
        */

        function requestBrowserPermission() {

            if (
                !('Notification' in window)
            ) {

                return;
            }


            if (
                Notification.permission ===
                'default'
            ) {

                Notification.requestPermission();

            }

        }


        function showBrowserNotification() {

            if (
                !('Notification' in window)
            ) {

                return;
            }


            if (
                Notification.permission ===
                'granted'
            ) {

                try {

                    new Notification(
                        'OptiCare - New Online Appointment',
                        {
                            body:
                                'A new online appointment has been submitted.',
                            icon:
                                '/favicon.ico'
                        }
                    );

                } catch (error) {

                    console.log(
                        'Browser notification error:',
                        error
                    );

                }

            }

        }


        /*
        |--------------------------------------------------------------------------
        | CHECK ONLINE APPOINTMENT
        |--------------------------------------------------------------------------
        */

        async function checkOnlineAppointment() {

            try {

                const response =
                    await fetch(
                        "{{ route('notifications.check-online-appointment') }}",
                        {
                            method: 'GET',

                            headers: {
                                'Accept':
                                    'application/json',

                                'X-Requested-With':
                                    'XMLHttpRequest'
                            },

                            cache:
                                'no-store'
                        }
                    );


                if (!response.ok) {

                    return;
                }


                const data =
                    await response.json();


                if (
                    !data.success ||
                    !data.has_new ||
                    !data.appointment_id
                ) {

                    return;
                }


                const currentAppointmentId =
                    String(
                        data.appointment_id
                    );


                /*
                |--------------------------------------------------------------------------
                | FIRST LOAD
                |--------------------------------------------------------------------------
                |
                | Existing appointment should NOT trigger sound.
                |
                */

                if (!lastAppointmentId) {

                    lastAppointmentId =
                        currentAppointmentId;


                    localStorage.setItem(
                        storageKey,
                        currentAppointmentId
                    );


                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | NEW ONLINE APPOINTMENT
                |--------------------------------------------------------------------------
                */

                if (
                    currentAppointmentId !==
                    String(lastAppointmentId)
                ) {

                    lastAppointmentId =
                        currentAppointmentId;


                    localStorage.setItem(
                        storageKey,
                        currentAppointmentId
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | SOUND
                    |--------------------------------------------------------------------------
                    */

                    playNotificationSound();


                    /*
                    |--------------------------------------------------------------------------
                    | BROWSER NOTIFICATION
                    |--------------------------------------------------------------------------
                    */

                    showBrowserNotification();


                    /*
                    |--------------------------------------------------------------------------
                    | SHAKE BELL
                    |--------------------------------------------------------------------------
                    */

                    const bell =
                        document.querySelector(
                            '#notificationDropdown i'
                        );


                    if (bell) {

                        bell.classList.add(
                            'notification-shake'
                        );


                        setTimeout(
                            function () {

                                bell.classList.remove(
                                    'notification-shake'
                                );

                            },
                            1000
                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | RELOAD
                    |--------------------------------------------------------------------------
                    |
                    | Updates the notification counts.
                    |
                    */

                    setTimeout(
                        function () {

                            window.location.reload();

                        },
                        1200
                    );

                }

            } catch (error) {

                console.log(
                    'Online appointment check failed:',
                    error
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | REQUEST NOTIFICATION PERMISSION
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            requestBrowserPermission,
            {
                once: true
            }
        );


        /*
        |--------------------------------------------------------------------------
        | INITIAL CHECK
        |--------------------------------------------------------------------------
        */

        checkOnlineAppointment();


        /*
        |--------------------------------------------------------------------------
        | CHECK EVERY 5 SECONDS
        |--------------------------------------------------------------------------
        */

        setInterval(
            checkOnlineAppointment,
            5000
        );

    }
);

</script>


</body>

</html>