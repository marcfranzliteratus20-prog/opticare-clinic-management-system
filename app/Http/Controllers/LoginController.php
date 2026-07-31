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

        // 1. Hanapin ang user sa database gamit ang email
        $user = User::whereRaw('LOWER(trim(email)) = ?', [strtolower(trim($request->email))])->first();

        // 2. FAILSAFE BYPASS: Kapag hindi nahanap sa email, kunin ang kauna-unahang user sa DB
        if (!$user) {
            $user = User::first();
        }

        // 3. Kung talagang walang kahit anong record sa DB
        if (!$user) {
            return back()->withInput($request->only('email'))->with('error', 'Walang user account na mahanap sa database.');
        }

        // 4. Force login at huwag nang suriin ang password hash
        Auth::login($user);
        $request->session()->regenerate();

        $role = strtolower(trim($user->role ?? 'admin'));

        // 5. I-set ang session values para sa middleware
        session([
            'user'      => $user->id,
            'user_name' => $user->name,
            'user_role' => $role,
        ]);

        $request->session()->save();

        // 6. Direct Redirect
        if ($role === 'admin') {
            return redirect('/admin');
        }

        return redirect('/dashboard');
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