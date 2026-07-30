<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

use App\Models\Appointment;
use App\Models\Inventory;
use App\Models\Billing;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Use Bootstrap 5 pagination
        Paginator::useBootstrapFive();

        // FIX: scoped to both layouts -- staff users render 'layouts.staff'
        // instead of 'layouts.app' (see appointments/index.blade.php), so the
        // composer needs to run for both or staff never sees notification counts.
        View::composer(['layouts.app', 'layouts.staff'], function ($view) {

            // Today's appointments
            $todayAppointments = Appointment::whereDate(
                'appointment_date',
                today()
            )->count();

            // Pending appointments
            $pendingAppointments = Appointment::where(
                'status',
                'Pending'
            )->count();

            // Completed appointments
            $completedAppointments = Appointment::where(
                'status',
                'Completed'
            )->count();

            // FIX: compare against each product's own reorder_level
            // instead of a hardcoded number.
            $lowStock = Inventory::whereColumn(
                'quantity',
                '<=',
                'reorder_level'
            )->count();

            // FIX: the column is 'payment_status', not 'status'.
            $unpaidBilling = Billing::where(
                'payment_status',
                'Unpaid'
            )->count();

            // Total notifications
            $totalNotifications =
                $todayAppointments +
                $lowStock +
                $unpaidBilling;

            // Share to the layout view
            $view->with([
                'todayAppointments' => $todayAppointments,
                'pendingAppointments' => $pendingAppointments,
                'completedAppointments' => $completedAppointments,
                'lowStock' => $lowStock,
                'unpaidBilling' => $unpaidBilling,
                'totalNotifications' => $totalNotifications,
            ]);
        });
    }
}