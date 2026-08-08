<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        /*
        |--------------------------------------------------------------------------
        | Check if user is logged in
        |--------------------------------------------------------------------------
        |
        | Your application uses a custom session:
        |
        | session('user')
        | session('user_name')
        | session('user_role')
        |
        */

        if (!session()->has('user')) {
            return redirect()
                ->route('login')
                ->with('error', 'Please log in first.');
        }

        /*
        |--------------------------------------------------------------------------
        | Make sure the session has a valid user ID
        |--------------------------------------------------------------------------
        */

        if (!session('user')) {
            session()->forget([
                'user',
                'user_name',
                'user_role',
            ]);

            return redirect()
                ->route('login')
                ->with('error', 'Your session has expired. Please log in again.');
        }

        return $next($request);
    }
}