<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!session()->has('user_role')) {
            return redirect()->route('login');
        }

        if (!in_array(session('user_role'), $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}