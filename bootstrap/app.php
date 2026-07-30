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
        
        // DITO MO IRE-REGISTER ANG MIDDLEWARE ALIAS MO
        $middleware->alias([
            'check.login' => \App\Http\Middleware\CheckLogin::class, // Siguraduhing tama ang class path ng middleware mo
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();