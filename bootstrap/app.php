<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Throwable $e) {
            $previous = $e->getPrevious();
            if ($previous instanceof ModelNotFoundException) {
                $fullModel = $previous->getModel();
                $model = str($fullModel)->afterLast('\\');
                return response()->json([
                    'message' => $model . ' not found',
                ], Response::HTTP_NOT_FOUND);
            }
        });

        //
    })->create();
