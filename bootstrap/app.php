<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\logedinMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckAppExpiry; // 👈 add this

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // 👇 Option 1: Alias (use in routes)
        $middleware->alias([
            'is_login'   => AuthMiddleware::class,
            'is_admin'   => logedinMiddleware::class,
            'admin'      => AdminMiddleware::class,
            'check.expiry' => CheckAppExpiry::class, // 👈 add alias
        ]);

        // 👇 Option 2: Global (uncomment if you want app-wide expiry)
        // $middleware->append(CheckAppExpiry::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
