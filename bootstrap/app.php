<?php

use App\Listeners\LogAuthActivity;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Event;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'superadmin' => \App\Http\Middleware\SuperadminMiddleware::class,
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\LogActivity::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

Event::listen(Login::class, [LogAuthActivity::class, 'handleLogin']);
Event::listen(Logout::class, [LogAuthActivity::class, 'handleLogout']);
