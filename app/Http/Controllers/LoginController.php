<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Hanapin ang user o gumawa ng temporary dummy user object sa memory
        $user = User::first();

        if ($user) {
            Auth::login($user);
            $userId = $user->id;
            $userName = $user->name;
            $userRole = strtolower(trim($user->role ?? 'admin'));
        } else {
            // Kung walang laman ang database, mag-set ng default dummy session
            $userId = 1;
            $userName = 'Admin User';
            $userRole = 'admin';
        }

        // 2. Force set session variables
        session([
            'user'      => $userId,
            'user_name' => $userName,
            'user_role' => $userRole,
        ]);

        $request->session()->save();

        return redirect('/admin');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}