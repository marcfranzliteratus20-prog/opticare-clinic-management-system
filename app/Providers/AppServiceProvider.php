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
        | GLOBAL NOTIFICATIONS
        |--------------------------------------------------------------------------
        */

        View::composer('*', function ($view) {

            /*
            |--------------------------------------------------------------------------
            | TODAY'S APPOINTMENTS
            |--------------------------------------------------------------------------
            */

            $todayAppointments = Appointment::whereDate(
                'appointment_date',
                now()->toDateString()
            )->count();


            /*
            |--------------------------------------------------------------------------
            | PENDING APPOINTMENTS
            |--------------------------------------------------------------------------
            */

            $pendingAppointments = Appointment::where(
                'status',
                'Pending'
            )->count();


            /*
            |--------------------------------------------------------------------------
            | COMPLETED APPOINTMENTS
            |--------------------------------------------------------------------------
            */

            $completedAppointments = Appointment::where(
                'status',
                'Completed'
            )->count();


            /*
            |--------------------------------------------------------------------------
            | LOW STOCK
            |--------------------------------------------------------------------------
            */

            $lowStock = Inventory::where(
                'quantity',
                '<=',
                5
            )->count();


            /*
            |--------------------------------------------------------------------------
            | UNPAID BILLING
            |--------------------------------------------------------------------------
            */

            $unpaidBilling = Billing::where(
                'status',
                'Unpaid'
            )->count();


            /*
            |--------------------------------------------------------------------------
            | TOTAL NOTIFICATIONS
            |--------------------------------------------------------------------------
            */

            $totalNotifications =
                $todayAppointments +
                $pendingAppointments +
                $lowStock +
                $unpaidBilling;


            /*
            |--------------------------------------------------------------------------
            | SHARE VARIABLES
            |--------------------------------------------------------------------------
            */

            $view->with([

                'todayAppointments' =>
                    $todayAppointments,

                'pendingAppointments' =>
                    $pendingAppointments,

                'completedAppointments' =>
                    $completedAppointments,

                'lowStock' =>
                    $lowStock,

                'unpaidBilling' =>
                    $unpaidBilling,

                'totalNotifications' =>
                    $totalNotifications,

            ]);
        });
    }
}