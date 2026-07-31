<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Subukang i-authenticate ang credentials
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $role = strtolower(trim($user->role ?? 'admin'));

            // I-set ang session values na kailangan ng iyong CheckLogin at CheckRole middleware
            session([
                'user'      => $user->id,
                'user_name' => $user->name,
                'user_role' => $role,
            ]);

            $request->session()->save();

            // Redirect batay sa role
            if ($role === 'admin') {
                return redirect('/admin');
            }

            return redirect('/dashboard');
        }

        return back()->withInput($request->only('email'))->with('error', 'Invalid email or password.');
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