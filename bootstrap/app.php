<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');
        
        // Dito inirerehistro ang mga middleware aliases para sa Laravel 11/12
        $middleware->alias([
            'check.login' => \App\Http\Middleware\CheckLogin::class,
            'role'        => \App\Http\Middleware\CheckRole::class, // Gamit ang iyong custom CheckRole middleware
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

    