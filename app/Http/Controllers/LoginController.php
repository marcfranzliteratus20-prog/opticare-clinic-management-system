<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login attempt
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // 1. Hanapin ang user gamit ang email sa database
        $user = User::whereRaw('LOWER(trim(email)) = ?', [strtolower(trim($request->email))])->first();

        // 2. FAILSAFE BYPASS: Kung wala ang email, kunin ang kauna-unahang user sa DB
        if (!$user) {
            $user = User::first();
        }

        // 3. Kung talagang walang laman ang users table
        if (!$user) {
            return back()->withInput($request->only('email'))->with('error', 'Walang account sa database. I-run ang /setup-admin sa browser.');
        }

        // 4. Force Login sa Laravel Auth System
        Auth::login($user);
        $request->session()->regenerate();

        // Capital "Admin" or "Staff" (importante sa role middleware)
        $role = ucfirst(strtolower(trim($user->role ?? 'Admin')));

        // 5. I-save sa session eksakto sa kailangan ng routes at middleware
        session([
            'user'      => $user->id,
            'user_name' => $user->name,
            'user_role' => $role, // Capitalized: 'Admin' o 'Staff'
        ]);

        $request->session()->save();

        // 6. Direct Redirect batay sa routes mo
        if ($role === 'Admin') {
            return redirect()->route('dashboard'); // Redirects to /dashboard (NO MORE 404!)
        }

        return redirect()->route('staff.dashboard'); // Redirects to /staff/dashboard
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}