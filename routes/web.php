<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;

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
| ROOT -- public landing page for guests. Logged-in users are redirected
| straight to their dashboard instead of seeing the marketing page.
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (session()->has('user')) {
        return session('user_role') === 'Admin'
            ? redirect()->route('dashboard')
            : redirect()->route('staff.dashboard');
    }

    return view('public.landing');
});

/*
|--------------------------------------------------------------------------
| PUBLIC ONLINE BOOKING -- no login required.
|--------------------------------------------------------------------------
*/
Route::get('/book-appointment', [BookingController::class, 'create'])->name('booking.create');
Route::post('/book-appointment', [BookingController::class, 'store'])->name('booking.store');

Route::get('/check-status', [BookingController::class, 'showStatusForm'])->name('booking.status.form');
Route::post('/check-status', [BookingController::class, 'checkStatus'])
    ->middleware('throttle:10,1')
    ->name('booking.status');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.submit');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('check.login')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | GLOBAL SEARCH (ADMIN + STAFF)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:Admin,Staff')->group(function () {
        Route::get('/search', [SearchController::class, 'index'])
            ->name('search');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:Admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('inventory', InventoryController::class);
        Route::put('/inventory/{inventory}/adjust', [InventoryController::class, 'adjustStock'])->name('inventory.adjust');
        Route::get('/inventory-history', [InventoryController::class, 'stockHistory'])->name('inventory.history');
        Route::get('/inventory-export', [InventoryController::class, 'exportCsv'])->name('inventory.export');

        Route::resource('users', UserController::class);

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');

        Route::get('/archive', [ArchiveController::class, 'index'])->name('archive.index');
        Route::put('/archive/{type}/{id}/restore', [ArchiveController::class, 'restore'])->name('archive.restore');
        Route::delete('/archive/{type}/{id}/force', [ArchiveController::class, 'forceDelete'])->name('archive.force');

        Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
        Route::post('/backup', [BackupController::class, 'create'])->name('backup.create');
        Route::get('/backup/{filename}/download', [BackupController::class, 'download'])->name('backup.download');
        Route::delete('/backup/{filename}', [BackupController::class, 'destroy'])->name('backup.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | STAFF ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:Staff')->group(function () {

        Route::get('/staff/dashboard', [DashboardController::class, 'staffDashboard'])
            ->name('staff.dashboard');
    });

    /*
    |--------------------------------------------------------------------------
    | SHARED MODULES (ADMIN + STAFF)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:Admin,Staff')->group(function () {

        Route::resource('patients', PatientController::class);

        Route::resource('appointments', AppointmentController::class);

        Route::put(
            '/appointments/{appointment}/complete',
            [AppointmentController::class, 'complete']
        )->name('appointments.complete');

        Route::resource('billing', BillingController::class);

        Route::put(
            '/billing/{billing}/paid',
            [BillingController::class, 'markPaid']
        )->name('billing.paid');

        Route::get('/billing/{billing}/receipt', [BillingController::class, 'receipt'])->name('billing.receipt');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });
});

/*
|--------------------------------------------------------------------------
| TEMPORARY SETUP & MIGRATION HELPER ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/run-migration', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Database Migration Completed Successfully!';
});

Route::get('/setup-admin', function () {
    $user = User::updateOrCreate(
        ['email' => 'marcfranz2004@gmail.com'],
        [
            'name' => 'Admin User',
            'password' => Hash::make('admin12345'),
            'role' => 'Admin', // Naka-capital "A" para sa role:Admin middleware
            'email_verified_at' => now(),
        ]
    );

    // Kina-catches din sa session para sa custom `check.login` middleware
    session([
        'user' => $user,
        'user_role' => 'Admin'
    ]);

    return 'SUCCESS! Admin user created or updated. You can now log in at /login with: marcfranz2004@gmail.com / admin12345';
});

Route::get('/force-login', function () {
    $user = User::where('email', 'marcfranz2004@gmail.com')->first();
    
    if (!$user) {
        return 'Wala pang user na ganyan sa database! I-run muna ang /setup-admin';
    }

    Auth::login($user);

    // Sine-set ang session na ginagamit sa root / check.login middleware
    session([
        'user' => $user,
        'user_role' => $user->role ?? 'Admin'
    ]);

    return redirect()->route('dashboard');
});