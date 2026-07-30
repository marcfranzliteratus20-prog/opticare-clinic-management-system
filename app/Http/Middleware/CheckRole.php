<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!session()->has('user_role')) {
            return redirect('/login')->with('error', 'Please log in to continue.');
        }

        $userRole = session('user_role');

        // Case-insensitive comparison so 'admin' in a route definition still
        // matches a stored role of 'Admin' -- avoids silent 403s from typos.
        $allowed = collect($roles)->contains(
            fn ($role) => strcasecmp($role, $userRole) === 0
        );

        if (!$allowed) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}