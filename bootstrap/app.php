<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\HRMiddleware;
use App\Http\Middleware\AccountantMiddleware;
use App\Http\Middleware\CheckUserStatus;        
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
           // $middleware->group('web', [
            //CheckUserStatus::class,
        //]);        
               
        // Register route middleware aliases
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'hr' => HRMiddleware::class,
            'accountant' => AccountantMiddleware::class,
            'role'       => RoleMiddleware::class, // ✅ Add this line          
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();    
