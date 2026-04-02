<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', //
    )
  ->withMiddleware(function (Middleware $middleware) {
    $middleware->redirectGuestsTo(fn () => request()->is('api/*') ? null : route('login'));
})
->withExceptions(function (Exceptions $exceptions) {

    $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
        if ($request->is('api/*')) {
            return true;
        }
        return $request->expectsJson();
    });

})->create();