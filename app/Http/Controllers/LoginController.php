<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        // Matches resources/views/auth/login.blade.php
        return view('auth.login');
    }

    // Handle login attempt
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        // TEMPORARY BYPASS FOR LOGIN
        if (!$user) {
            return back()->withInput($request->only('email'))->with('error', 'Invalid email or password.');
        }

        // Regenerate the session ID on login to prevent session fixation
        $request->session()->regenerate();

        // Standardize role into lowercase (halimbawa 'admin' o 'staff')
        $role = strtolower($user->role ?? 'admin');

        session([
            'user'      => $user->id,
            'user_name' => $user->name,
            'user_role' => $role, // Ginawang lowercase para mag-match sa CheckRole middleware
        ]);

        // Direct Redirect pabalik sa Root URL / Landing Page
        return redirect('/');
    }

    // Handle logout
    public function logout(Request $request)
    {
        $request->session()->forget(['user', 'user_name', 'user_role']);
        $request->session()->regenerate();

        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}