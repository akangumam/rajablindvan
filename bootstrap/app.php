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
    ->withMiddleware(function (Middleware $middleware): void {
        // Global middleware
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);
        
        // Middleware aliases
        $middleware->alias([
            'user.type' => \App\Http\Middleware\CheckUserType::class,
            'vehicle.access' => \App\Http\Middleware\CheckVehicleAccess::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
