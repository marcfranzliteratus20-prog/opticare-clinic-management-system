<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use App\Http\Controllers\PatientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| PUBLIC LANDING PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (session()->has('user')) {

        if (session('user_role') === 'Admin') {
            return redirect()->route('dashboard');
        }

        if (session('user_role') === 'Staff') {
            return redirect()->route('staff.dashboard');
        }

        session()->forget([
            'user',
            'user_name',
            'user_role',
        ]);
    }

    return view('public.landing');

})->name('home');


/*
|--------------------------------------------------------------------------
| PUBLIC ONLINE BOOKING
|--------------------------------------------------------------------------
*/

Route::get('/book-appointment', [
    BookingController::class,
    'create'
])->name('booking.create');

Route::post('/book-appointment', [
    BookingController::class,
    'store'
])->name('booking.store');


/*
|--------------------------------------------------------------------------
| PUBLIC APPOINTMENT STATUS
|--------------------------------------------------------------------------
*/

Route::get('/check-status', [
    BookingController::class,
    'showStatusForm'
])->name('booking.status.form');

Route::post('/check-status', [
    BookingController::class,
    'checkStatus'
])
->middleware('throttle:10,1')
->name('booking.status');


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

Route::get('/login', [
    LoginController::class,
    'showLoginForm'
])->name('login');

Route::post('/login', [
    LoginController::class,
    'login'
])
->middleware('throttle:5,1')
->name('login.submit');

Route::post('/logout', [
    LoginController::class,
    'logout'
])->name('logout');


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('check.login')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | GLOBAL SEARCH
    |--------------------------------------------------------------------------
    | ADMIN + STAFF
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:Admin,Staff')->group(function () {

        Route::get('/search', [
            SearchController::class,
            'index'
        ])->name('search');

    });


    /*
    |--------------------------------------------------------------------------
    | NOTIFICATION CHECK
    |--------------------------------------------------------------------------
    | ADMIN + STAFF
    |--------------------------------------------------------------------------
    |
    | JavaScript will check this every 5 seconds.
    | If a new Online appointment exists, it returns the appointment ID.
    |
    */

    Route::middleware('role:Admin,Staff')->group(function () {

        Route::get('/notifications/check-online-appointment', function () {

            try {

                if (!Schema::hasTable('appointments')) {

                    return response()->json([
                        'success' => true,
                        'has_new' => false,
                        'appointment_id' => null,
                    ]);
                }

                $query = DB::table('appointments');

                /*
                |--------------------------------------------------------------------------
                | Make sure source column exists
                |--------------------------------------------------------------------------
                */

                if (!Schema::hasColumn('appointments', 'source')) {

                    return response()->json([
                        'success' => true,
                        'has_new' => false,
                        'appointment_id' => null,
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Find latest ONLINE appointment
                |--------------------------------------------------------------------------
                */

                $latest = $query
                    ->whereRaw('LOWER(source) = ?', ['online'])
                    ->orderByDesc('id')
                    ->first();

                if (!$latest) {

                    return response()->json([
                        'success' => true,
                        'has_new' => false,
                        'appointment_id' => null,
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'has_new' => true,
                    'appointment_id' => $latest->id,
                    'created_at' => $latest->created_at ?? null,
                ]);

            } catch (\Throwable $e) {

                return response()->json([
                    'success' => false,
                    'has_new' => false,
                    'appointment_id' => null,
                ]);
            }

        })->name('notifications.check-online-appointment');

    });


    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:Admin')->group(function () {


        /*
        |--------------------------------------------------------------------------
        | ADMIN DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            DashboardController::class,
            'index'
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | INVENTORY
        |--------------------------------------------------------------------------
        */

        Route::resource('inventory', InventoryController::class);

        Route::put(
            '/inventory/{inventory}/adjust',
            [InventoryController::class, 'adjustStock']
        )->name('inventory.adjust');

        Route::get(
            '/inventory-history',
            [InventoryController::class, 'stockHistory']
        )->name('inventory.history');

        Route::get(
            '/inventory-export',
            [InventoryController::class, 'exportCsv']
        )->name('inventory.export');


        /*
        |--------------------------------------------------------------------------
        | USER MANAGEMENT
        |--------------------------------------------------------------------------
        */

        Route::resource('users', UserController::class);


        /*
        |--------------------------------------------------------------------------
        | REPORTS
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/reports',
            [ReportController::class, 'index']
        )->name('reports.index');

        Route::get(
            '/reports/pdf',
            [ReportController::class, 'exportPdf']
        )->name('reports.pdf');


        /*
        |--------------------------------------------------------------------------
        | ARCHIVE
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/archive',
            [ArchiveController::class, 'index']
        )->name('archive.index');

        Route::put(
            '/archive/{type}/{id}/restore',
            [ArchiveController::class, 'restore']
        )->name('archive.restore');

        Route::delete(
            '/archive/{type}/{id}/force',
            [ArchiveController::class, 'forceDelete']
        )->name('archive.force');


        /*
        |--------------------------------------------------------------------------
        | DATABASE BACKUP
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/backup',
            [BackupController::class, 'index']
        )->name('backup.index');

        Route::post(
            '/backup/create',
            [BackupController::class, 'create']
        )->name('backup.create');

        Route::get(
            '/backup/download/{filename}',
            [BackupController::class, 'download']
        )->name('backup.download');

        Route::delete(
            '/backup/delete/{filename}',
            [BackupController::class, 'destroy']
        )->name('backup.destroy');


        /*
        |--------------------------------------------------------------------------
        | DATABASE RESTORE
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/backup/restore',
            [BackupController::class, 'restoreForm']
        )->name('backup.restore.form');

        Route::post(
            '/backup/restore',
            [BackupController::class, 'restore']
        )->name('backup.restore');


        /*
        |--------------------------------------------------------------------------
        | BACKUP SCHEDULE
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/backup/schedule',
            [BackupController::class, 'schedule']
        )->name('backup.schedule');

        Route::post(
            '/backup/schedule',
            [BackupController::class, 'saveSchedule']
        )->name('backup.schedule.save');

    });


    /*
    |--------------------------------------------------------------------------
    | STAFF ONLY
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:Staff')->group(function () {

        Route::get(
            '/staff/dashboard',
            [DashboardController::class, 'staffDashboard']
        )->name('staff.dashboard');

    });


    /*
    |--------------------------------------------------------------------------
    | SHARED MODULES
    |--------------------------------------------------------------------------
    | ADMIN + STAFF
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:Admin,Staff')->group(function () {


        /*
        |--------------------------------------------------------------------------
        | PATIENTS
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'patients',
            PatientController::class
        );


        /*
        |--------------------------------------------------------------------------
        | APPOINTMENTS
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'appointments',
            AppointmentController::class
        );

        Route::put(
            '/appointments/{appointment}/complete',
            [AppointmentController::class, 'complete']
        )->name('appointments.complete');


        /*
        |--------------------------------------------------------------------------
        | BILLING
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'billing',
            BillingController::class
        );

        Route::put(
            '/billing/{billing}/paid',
            [BillingController::class, 'markPaid']
        )->name('billing.paid');

        Route::get(
            '/billing/{billing}/receipt',
            [BillingController::class, 'receipt']
        )->name('billing.receipt');


        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/profile',
            [ProfileController::class, 'edit']
        )->name('profile.edit');

        Route::put(
            '/profile',
            [ProfileController::class, 'update']
        )->name('profile.update');

    });

});