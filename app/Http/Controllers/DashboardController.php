<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Inventory;
use App\Models\Billing;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPatients = Patient::count();
        $totalProducts = Inventory::count();

        // NOTE: these ARE needed here even though AppServiceProvider also
        // computes similar values -- the composer only supplies data to
        // layouts/app.blade.php's own markup (topbar/sidebar). The content
        // section of dashboard.blade.php is separate child-view data and
        // must be passed explicitly from the controller.
        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
        $pendingAppointments = Appointment::where('status', 'Pending')->count();
        $completedAppointments = Appointment::where('status', 'Completed')->count();
        $lowStock = Inventory::whereColumn('quantity', '<=', 'reorder_level')->count();
        $unpaidBilling = Billing::where('payment_status', 'Unpaid')->count();

        return view('dashboard', compact(
            'totalPatients',
            'totalProducts',
            'todayAppointments',
            'pendingAppointments',
            'completedAppointments',
            'lowStock',
            'unpaidBilling'
        ));
    }

    public function staffDashboard()
    {
        $totalPatients = Patient::count();

        // NOTE: same correction as index() above -- staff/dashboard.blade.php
        // uses these directly in its own content section, so they must be
        // passed from the controller, not just relied on from the layout composer.
        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
        $pendingAppointments = Appointment::where('status', 'Pending')->count();
        $unpaidBilling = Billing::where('payment_status', 'Unpaid')->count();

        return view('staff.dashboard', compact(
            'totalPatients',
            'todayAppointments',
            'pendingAppointments',
            'unpaidBilling'
        ));
    }
}