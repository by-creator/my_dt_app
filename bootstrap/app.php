<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\ActivityLogger;
use App\Http\Middleware\AdminMiddleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withEvents([
        //
    ])
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(ActivityLogger::class);
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withProviders([
        App\Providers\AppEventServiceProvider::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();



return $app;
