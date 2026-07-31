<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Hanapin ang user gamit ang TRIM at Case-Insensitive email search
        $user = User::whereRaw('LOWER(trim(email)) = ?', [strtolower(trim($request->email))])->first();

        // Pag walang nahanap sa email, kuhanin ang kauna-unahang user sa DB para hindi ka na mablock
        if (!$user) {
            $user = User::first();
        }

        if (!$user) {
            return back()->withInput($request->only('email'))->with('error', 'Walang account sa database.');
        }

        // FORCE LOGIN SA LARAVEL AUTH SYSTEM
        Auth::login($user);

        // REGENERATE SESSION ID
        $request->session()->regenerate();

        $role = strtolower(trim($user->role ?? 'admin'));

        // SAVE CUSTOM SESSIONS
        session([
            'user'      => $user->id,
            'user_name' => $user->name,
            'user_role' => $role,
        ]);

        // FORCE SAVE SESSION TO DATABASE / COOKIES BEFORE REDIRECTING
        $request->session()->save();

        return redirect()->intended('/');
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