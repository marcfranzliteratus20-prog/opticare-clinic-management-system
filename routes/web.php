<?php

use Illuminate\Support\Facades\Route;

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

        // Invalid role/session
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
| No login required.
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
| No login required.
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

/*
|--------------------------------------------------------------------------
| Login Page
|--------------------------------------------------------------------------
*/

Route::get('/login', [
    LoginController::class,
    'showLoginForm'
])->name('login');


/*
|--------------------------------------------------------------------------
| Login Submit
|--------------------------------------------------------------------------
*/

Route::post('/login', [
    LoginController::class,
    'login'
])
->middleware('throttle:5,1')
->name('login.submit');


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
| POST only.
|--------------------------------------------------------------------------
*/

Route::post('/logout', [
    LoginController::class,
    'logout'
])->name('logout');


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
| User must be logged in.
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
        | PROFILE / ACCOUNT SETTINGS
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