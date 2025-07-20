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
        // Attach the SetLocale middleware to every web request
        $middleware->prependToGroup('web', \App\Http\Middleware\SetLocale::class);

        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
           
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Optional: customize exception handling
    })
    ->create();
