<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful; //я добавил

use Illuminate\Http\Request;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

//RateLimiter::for('api', function ($request) {
//    return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
//});

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',

    )


    ->withMiddleware(function (Middleware $middleware) {
       //Было пусто я добавил:
        $middleware->validateCsrfTokens(except: [
            'login',
            'api/*'
        ]);

        $middleware->group('api', [
            EnsureFrontendRequestsAreStateful::class,

// Вот из-за этой строки падал сервак          \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
//        ->withRateLimiting(function () {
//            RateLimiter::for('api', function ($request) {
//               return Limit::perMinute(60)->by(
//               optional($request->user())->id ?: $request->ip()
//                );
//            });
//        })
    ->create();

