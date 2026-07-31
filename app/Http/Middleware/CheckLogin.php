<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('user')) {
            // Small UX improvement: let the login page explain why the
            // user was sent there, instead of a silent redirect.
            return redirect('/login')->with('error', 'Please log in to continue.');
        }

        return $next($request);
    }
}