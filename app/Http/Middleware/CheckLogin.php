<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Tinitingnan kapag may NAKALOGIN na user sa Auth o sa Custom Session
        if (!Auth::check() && !session()->has('user')) {
            return redirect('/login')->with('error', 'Please log in to continue.');
        }

        return $next($request);
    }
}