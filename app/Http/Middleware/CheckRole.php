<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Kunin ang user sa Auth o mag-fallback sa session
        $user = Auth::user();
        $userRole = $user->role ?? session('user_role');

        if (!$userRole) {
            return redirect('/login')->with('error', 'Please log in to continue.');
        }

        // Case-insensitive check para sa roles
        $allowed = collect($roles)->contains(
            fn ($role) => strcasecmp($role, $userRole) === 0
        );

        if (!$allowed) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}