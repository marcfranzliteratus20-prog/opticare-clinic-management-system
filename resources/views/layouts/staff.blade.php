<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'OptiCare Clinic Management System')
    </title>

    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    {{-- Bootstrap Icons --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    {{-- Fonts --}}
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


        /* ========================================
           GENERAL
        ======================================== */

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


        /* ========================================
           TOP BAR
        ======================================== */

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

            z-index: 1000;
        }


        /* LOGO */

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


        /* RIGHT SIDE */

        .topbar-right {

            display: flex;

            align-items: center;

            gap: 18px;
        }


        /* ========================================
           SEARCH
        ======================================== */

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

            width: 230px;

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


        /* ========================================
           NOTIFICATION
        ======================================== */

        .notification-wrapper {

            position: relative;
        }


        /* BELL BUTTON */

        .notification-btn {

            position: relative;

            width: 40px;

            height: 40px;

            border-radius: 50%;

            border:
                1px solid rgba(255,255,255,0.18);

            background:
                rgba(255,255,255,0.10);

            color: white;

            display: flex;

            align-items: center;

            justify-content: center;

            cursor: pointer;

            transition:
                all 0.2s ease;
        }

        .notification-btn:hover {

            background:
                rgba(255,255,255,0.20);

            transform: translateY(-1px);
        }

        .notification-btn i {

            font-size: 1.05rem;
        }


        /* NOTIFICATION BADGE */

        .notification-badge {

            position: absolute;

            top: -5px;

            right: -5px;

            min-width: 19px;

            height: 19px;

            padding:
                0 5px;

            border-radius: 20px;

            background:
                var(--oc-terracotta);

            color: white;

            font-size: 0.65rem;

            font-weight: 700;

            display: flex;

            align-items: center;

            justify-content: center;

            border:
                2px solid var(--oc-teal-dark);
        }


        /* NOTIFICATION DROPDOWN */

        .notification-dropdown {

            position: absolute;

            top: 52px;

            right: 0;

            width: 350px;

            background: white;

            color: var(--oc-ink);

            border-radius: 16px;

            box-shadow:
                0 15px 40px rgba(28,43,51,0.18);

            border:
                1px solid rgba(28,43,51,0.08);

            overflow: hidden;

            display: none;

            z-index: 2000;
        }


        .notification-dropdown.show {

            display: block;
        }


        /* NOTIFICATION HEADER */

        .notification-header {

            padding:
                15px 17px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            border-bottom:
                1px solid rgba(28,43,51,0.07);
        }

        .notification-header strong {

            font-size: 0.95rem;
        }

        .notification-header span {

            font-size: 0.72rem;

            color: #8a8a85;
        }


        /* NOTIFICATION ITEM */

        .notification-item {

            display: flex;

            align-items: flex-start;

            gap: 12px;

            padding:
                14px 17px;

            text-decoration: none;

            color: var(--oc-ink);

            border-bottom:
                1px solid rgba(28,43,51,0.05);

            transition:
                background 0.2s ease;
        }

        .notification-item:hover {

            background:
                var(--oc-teal-light);

            color: var(--oc-ink);
        }


        /* NOTIFICATION ICON */

        .notification-icon {

            flex-shrink: 0;

            width: 38px;

            height: 38px;

            border-radius: 11px;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 1rem;
        }


        .notification-danger {

            background:
                rgba(193,83,58,0.12);

            color:
                var(--oc-terracotta);
        }


        .notification-gold {

            background:
                rgba(201,138,62,0.14);

            color:
                var(--oc-amber-dark);
        }


        /* NOTIFICATION TEXT */

        .notification-text {

            display: flex;

            flex-direction: column;

            gap: 3px;

            min-width: 0;
        }

        .notification-text strong {

            font-size: 0.82rem;
        }

        .notification-text span {

            font-size: 0.74rem;

            color: #8a8a85;

            line-height: 1.4;
        }


        /* NO NOTIFICATION */

        .notification-empty {

            padding: 28px 15px;

            display: flex;

            flex-direction: column;

            align-items: center;

            gap: 8px;

            color: #8a8a85;

            font-size: 0.8rem;
        }

        .notification-empty i {

            font-size: 1.7rem;

            color:
                var(--oc-sage);
        }


        /* ========================================
           USER
        ======================================== */

        .topbar-user {

            display: flex;

            align-items: center;

            gap: 10px;
        }


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

            color:
                rgba(255,255,255,0.65);
        }


        /* ========================================
           SIDEBAR
        ======================================== */

        .sidebar {

            width: 250px;

            height: calc(100vh - 70px);

            position: fixed;

            top: 70px;

            left: 0;

            padding: 24px 16px;

            background: #ffffff;

            box-shadow:
                4px 0 20px rgba(28,43,51,0.04);

            border-right:
                1px solid rgba(28,43,51,0.06);

            overflow-y: auto;

            z-index: 900;
        }


        /* SIDEBAR HEADER */

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


        /* SIDEBAR LINKS */

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

            transition:
                all 0.2s ease;

            background: none;

            border: none;

            text-align: left;

            cursor: pointer;
        }


        .sidebar a:hover,
        .sidebar form button:hover {

            background:
                var(--oc-teal-light);

            color:
                var(--oc-teal);
        }


        .sidebar a.active {

            background:
                var(--oc-teal);

            color: white;

            box-shadow:
                0 4px 12px rgba(27,75,79,0.25);
        }


        .sidebar-divider {

            border: none;

            border-top:
                1px solid rgba(28,43,51,0.08);

            margin: 14px 0;
        }


        .logout-btn {

            color:
                var(--oc-terracotta) !important;
        }


        .logout-btn:hover {

            background:
                rgba(193,83,58,0.08) !important;
        }


        /* ========================================
           CONTENT
        ======================================== */

        .content {

            margin-left: 250px;

            margin-top: 70px;

            padding: 28px;

            min-height:
                calc(100vh - 70px);
        }


        /* ========================================
           RESPONSIVE
        ======================================== */

        @media (max-width: 900px) {

            .topbar-search {
                display: none;
            }

            .sidebar {
                width: 220px;
            }

            .content {
                margin-left: 220px;
            }
        }


        @media (max-width: 700px) {

            .topbar {

                padding:
                    0 15px;
            }

            .topbar-user-info {
                display: none;
            }

            .sidebar {

                width: 72px;

                padding:
                    20px 10px;
            }

            .sidebar-header {

                padding:
                    12px 5px;

                font-size:
                    0;
            }

            .sidebar-header i {

                font-size:
                    1.3rem;
            }

            .sidebar-header span {

                display: none;
            }

            .sidebar-header small {

                display: none;
            }

            .sidebar a,
            .sidebar form button {

                justify-content: center;

                padding:
                    12px 5px;
            }

            .sidebar a i,
            .sidebar form button i {

                margin-right: 0 !important;
            }

            .sidebar a {

                font-size: 0;
            }

            .sidebar form button {

                font-size: 0;
            }

            .content {

                margin-left: 72px;

                padding:
                    20px 12px;
            }

            .notification-dropdown {

                position: fixed;

                top: 70px;

                right: 12px;

                width:
                    calc(100vw - 24px);

                max-width:
                    350px;
            }
        }

    </style>

    @stack('styles')

</head>


<body>


    {{-- ========================================
         NOTIFICATION DATA
    ======================================== --}}

    @php

        $lowStockCount = \App\Models\Inventory::whereColumn(
            'quantity',
            '<=',
            'reorder_level'
        )->count();

        $todayAppointments = \App\Models\Appointment::whereDate(
            'appointment_date',
            today()
        )->count();

        $notificationCount =
            $lowStockCount +
            $todayAppointments;

    @endphp



    {{-- ========================================
         TOP BAR
    ======================================== --}}

    <div class="topbar">


        {{-- LOGO --}}

        <div class="logo">

            <i class="bi bi-eyeglasses me-2"></i>

            OptiCare

        </div>



        {{-- RIGHT SIDE --}}

        <div class="topbar-right">


            {{-- SEARCH --}}

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



            {{-- ========================================
                 NOTIFICATION
            ======================================== --}}

            <div class="notification-wrapper">


                <button
                    type="button"
                    class="notification-btn"
                    id="notificationBtn"
                    aria-label="Notifications"
                    aria-expanded="false"
                >

                    <i class="bi bi-bell"></i>


                    @if($notificationCount > 0)

                        <span class="notification-badge">

                            {{ $notificationCount > 99 ? '99+' : $notificationCount }}

                        </span>

                    @endif

                </button>



                {{-- NOTIFICATION DROPDOWN --}}

                <div
                    class="notification-dropdown"
                    id="notificationDropdown"
                >


                    {{-- HEADER --}}

                    <div class="notification-header">

                        <strong>
                            Notifications
                        </strong>


                        @if($notificationCount > 0)

                            <span>

                                {{ $notificationCount }}

                                alert{{ $notificationCount > 1 ? 's' : '' }}

                            </span>

                        @else

                            <span>
                                All clear
                            </span>

                        @endif

                    </div>



                    {{-- LOW STOCK --}}

                    @if($lowStockCount > 0)

                        <a
                            href="{{ route('inventory.index') }}"
                            class="notification-item"
                        >

                            <div class="notification-icon notification-danger">

                                <i class="bi bi-box-seam"></i>

                            </div>


                            <div class="notification-text">

                                <strong>
                                    Low Stock
                                </strong>

                                <span>

                                    {{ $lowStockCount }}

                                    product{{ $lowStockCount > 1 ? 's' : '' }}

                                    {{ $lowStockCount > 1 ? 'are' : 'is' }}

                                    at or below the reorder level.

                                </span>

                            </div>

                        </a>

                    @endif



                    {{-- TODAY'S APPOINTMENTS --}}

                    @if($todayAppointments > 0)

                        <a
                            href="{{ route('appointments.index') }}"
                            class="notification-item"
                        >

                            <div class="notification-icon notification-gold">

                                <i class="bi bi-calendar-check"></i>

                            </div>


                            <div class="notification-text">

                                <strong>
                                    Today's Appointments
                                </strong>

                                <span>

                                    {{ $todayAppointments }}

                                    appointment{{ $todayAppointments > 1 ? 's' : '' }}

                                    scheduled today.

                                </span>

                            </div>

                        </a>

                    @endif



                    {{-- NO NOTIFICATIONS --}}

                    @if($notificationCount == 0)

                        <div class="notification-empty">

                            <i class="bi bi-check-circle"></i>

                            <span>
                                No new notifications
                            </span>

                        </div>

                    @endif


                </div>

            </div>



            {{-- ========================================
                 USER
            ======================================== --}}

            <div class="topbar-user">


                <div class="topbar-avatar">

                    {{ strtoupper(
                        substr(
                            session('user_name', 'S'),
                            0,
                            1
                        )
                    ) }}

                </div>


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



    {{-- ========================================
         SIDEBAR
    ======================================== --}}

    <div class="sidebar">


        {{-- SIDEBAR HEADER --}}

        <div class="sidebar-header">

            <i class="bi bi-eyeglasses me-2"></i>

            <span>
                OptiCare
            </span>

            <small>
                Staff Panel
            </small>

        </div>



        {{-- DASHBOARD --}}

        <a
            href="{{ route('staff.dashboard') }}"
            class="{{ request()->routeIs('staff.dashboard') ? 'active' : '' }}"
        >

            <i class="bi bi-speedometer2 me-2"></i>

            Dashboard

        </a>



        {{-- PATIENTS --}}

        <a
            href="{{ route('patients.index') }}"
            class="{{ request()->routeIs('patients.*') ? 'active' : '' }}"
        >

            <i class="bi bi-person-lines-fill me-2"></i>

            Patients

        </a>



        {{-- APPOINTMENTS --}}

        <a
            href="{{ route('appointments.index') }}"
            class="{{ request()->routeIs('appointments.*') ? 'active' : '' }}"
        >

            <i class="bi bi-calendar-check me-2"></i>

            Appointments

        </a>



        {{-- BILLING --}}

        <a
            href="{{ route('billing.index') }}"
            class="{{ request()->routeIs('billing.*') ? 'active' : '' }}"
        >

            <i class="bi bi-receipt me-2"></i>

            Billing

        </a>



        {{-- INVENTORY --}}

        <a
            href="{{ route('inventory.index') }}"
            class="{{ request()->routeIs('inventory.*') ? 'active' : '' }}"
        >

            <i class="bi bi-box-seam me-2"></i>

            Inventory

        </a>



        {{-- REPORTS --}}

        <a
            href="{{ route('reports.index') }}"
            class="{{ request()->routeIs('reports.*') ? 'active' : '' }}"
        >

            <i class="bi bi-graph-up me-2"></i>

            Reports

        </a>



        <hr class="sidebar-divider">



        {{-- ACCOUNT SETTINGS --}}

        <a
            href="{{ route('profile.edit') }}"
            class="{{ request()->routeIs('profile.*') ? 'active' : '' }}"
        >

            <i class="bi bi-person-gear me-2"></i>

            Account Settings

        </a>



        {{-- LOGOUT --}}

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



    {{-- ========================================
         PAGE CONTENT
    ======================================== --}}

    <main class="content">

        @yield('content')

    </main>



    {{-- ========================================
         BOOTSTRAP
    ======================================== --}}

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>



    {{-- ========================================
         NOTIFICATION JAVASCRIPT
    ======================================== --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {


            const notificationBtn =
                document.getElementById('notificationBtn');


            const notificationDropdown =
                document.getElementById('notificationDropdown');


            if (
                !notificationBtn ||
                !notificationDropdown
            ) {

                return;

            }


            /* OPEN / CLOSE */

            notificationBtn.addEventListener(
                'click',
                function (event) {

                    event.stopPropagation();

                    const isOpen =
                        notificationDropdown.classList.toggle('show');

                    notificationBtn.setAttribute(
                        'aria-expanded',
                        isOpen ? 'true' : 'false'
                    );

                }
            );


            /* CLOSE WHEN CLICKING OUTSIDE */

            document.addEventListener(
                'click',
                function (event) {

                    if (
                        !notificationDropdown.contains(event.target) &&
                        !notificationBtn.contains(event.target)
                    ) {

                        notificationDropdown.classList.remove('show');

                        notificationBtn.setAttribute(
                            'aria-expanded',
                            'false'
                        );

                    }

                }
            );


            /* ESC KEY */

            document.addEventListener(
                'keydown',
                function (event) {

                    if (event.key === 'Escape') {

                        notificationDropdown.classList.remove('show');

                        notificationBtn.setAttribute(
                            'aria-expanded',
                            'false'
                        );

                    }

                }
            );

        });

    </script>


    @stack('scripts')

</body>

</html>