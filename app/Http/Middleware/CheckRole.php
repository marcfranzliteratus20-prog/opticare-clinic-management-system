<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | Check if user is logged in
        |--------------------------------------------------------------------------
        */

        if (!session()->has('user')) {
            return redirect()
                ->route('login')
                ->with('error', 'Please log in first.');
        }


        /*
        |--------------------------------------------------------------------------
        | Get current user's role
        |--------------------------------------------------------------------------
        */

        $userRole = session('user_role');


        /*
        |--------------------------------------------------------------------------
        | Normalize role names
        |--------------------------------------------------------------------------
        |
        | This allows:
        | Admin
        | admin
        | ADMIN
        |
        | to be treated as the same role.
        |
        */

        $userRole = strtolower(trim((string) $userRole));


        /*
        |--------------------------------------------------------------------------
        | Normalize allowed roles
        |--------------------------------------------------------------------------
        */

        $allowedRoles = array_map(
            fn ($role) => strtolower(trim($role)),
            $roles
        );


        /*
        |--------------------------------------------------------------------------
        | Check permission
        |--------------------------------------------------------------------------
        */

        if (!in_array($userRole, $allowedRoles, true)) {

            /*
            | If the user is logged in but does not have permission,
            | redirect them to the appropriate dashboard.
            */

            if ($userRole === 'admin') {
                return redirect()->route('dashboard');
            }

            if ($userRole === 'staff') {
                return redirect()->route('staff.dashboard');
            }

            /*
            | Unknown or invalid role.
            */

            session()->forget([
                'user',
                'user_name',
                'user_role',
            ]);

            return redirect()
                ->route('login')
                ->with('error', 'Your account role is invalid. Please log in again.');
        }


        /*
        |--------------------------------------------------------------------------
        | Role is allowed
        |--------------------------------------------------------------------------
        */

        return $next($request);
    }
}