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
        /*
        |--------------------------------------------------------------------------
        | USE BOOTSTRAP 5 PAGINATION
        |--------------------------------------------------------------------------
        */

        Paginator::useBootstrapFive();


        /*
        |--------------------------------------------------------------------------
        | GLOBAL NOTIFICATIONS & BADGES
        |--------------------------------------------------------------------------
        */

        View::composer('*', function ($view) {
            try {
                $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
                $pendingAppointments = Appointment::where('status', 'Pending')->count();
                $completedAppointments = Appointment::where('status', 'Completed')->count();
                $lowStock = Inventory::whereColumn('quantity', '<=', 'reorder_level')->count();
                $unpaidBilling = Billing::where('payment_status', 'Unpaid')->count();

                $totalNotifications =
                    $todayAppointments +
                    $pendingAppointments +
                    $lowStock +
                    $unpaidBilling;

                $view->with([
                    'todayAppointments'     => $todayAppointments,
                    'pendingAppointments'   => $pendingAppointments,
                    'completedAppointments' => $completedAppointments,
                    'lowStock'              => $lowStock,
                    'unpaidBilling'         => $unpaidBilling,
                    'totalNotifications'    => $totalNotifications,
                ]);
            } catch (\Throwable $e) {
                $view->with([
                    'todayAppointments'     => 0,
                    'pendingAppointments'   => 0,
                    'completedAppointments' => 0,
                    'lowStock'              => 0,
                    'unpaidBilling'         => 0,
                    'totalNotifications'    => 0,
                ]);
            }
        });
    }
}