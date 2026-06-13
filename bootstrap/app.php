<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Fruitcake\Cors\HandleCors::class, // Ensure this line is present
            \Illuminate\Http\Middleware\HandleCors::class, // Ensure this middleware is present
        ]);


        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'delivery'=>\App\Http\Middleware\DeliveryMiddleware::class,
            'deliveryOrAdmin'=>\App\Http\Middleware\DeliveryOrAdminMiddleware::class,
            'cache.response' => \App\Http\Middleware\CacheResponse::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
