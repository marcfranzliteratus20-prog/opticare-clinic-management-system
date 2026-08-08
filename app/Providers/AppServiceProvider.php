<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Appointment;
use App\Models\Inventory;
use App\Models\Billing;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer([
            'layouts.app',
            'layouts.staff',
        ], function ($view) {

            /*
            |--------------------------------------------------------------------------
            | APPOINTMENTS
            |--------------------------------------------------------------------------
            */

            $todayAppointments = 0;
            $pendingAppointments = 0;
            $completedAppointments = 0;

            try {
                $todayAppointments = Appointment::whereDate(
                    'appointment_date',
                    now()->toDateString()
                )->count();

                $pendingAppointments = Appointment::where(
                    'status',
                    'Pending'
                )->count();

                $completedAppointments = Appointment::where(
                    'status',
                    'Completed'
                )->count();

            } catch (\Throwable $e) {
                // Prevent layout from breaking if a column/table is unavailable.
            }


            /*
            |--------------------------------------------------------------------------
            | LOW STOCK
            |--------------------------------------------------------------------------
            */

            $lowStock = 0;

            try {
                $lowStock = Inventory::whereColumn(
                    'quantity',
                    '<=',
                    'reorder_level'
                )->count();

            } catch (\Throwable $e) {
                // Prevent layout from breaking.
            }


            /*
            |--------------------------------------------------------------------------
            | UNPAID BILLING
            |--------------------------------------------------------------------------
            */

            $unpaidBilling = 0;

            try {

                /*
                 * Change "status" if your billing table uses
                 * another column for payment status.
                 */

                $unpaidBilling = Billing::whereIn('status', [
                    'Unpaid',
                    'Pending',
                    ' unpaid',
                    'pending',
                ])->count();

            } catch (\Throwable $e) {
                // Prevent layout from breaking.
            }


            /*
            |--------------------------------------------------------------------------
            | TOTAL NOTIFICATIONS
            |--------------------------------------------------------------------------
            */

            $totalNotifications =
                $todayAppointments +
                $lowStock +
                $unpaidBilling;


            /*
            |--------------------------------------------------------------------------
            | SHARE WITH LAYOUTS
            |--------------------------------------------------------------------------
            */

            $view->with([
                'todayAppointments'     => $todayAppointments,
                'pendingAppointments'   => $pendingAppointments,
                'completedAppointments' => $completedAppointments,
                'lowStock'              => $lowStock,
                'unpaidBilling'         => $unpaidBilling,
                'totalNotifications'    => $totalNotifications,
            ]);
        });
    }
}