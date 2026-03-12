<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if (! ($request->is('api/*') || $request->expectsJson())) {
                return null;
            }

            if ($request->is('api/login')) {
                return response()->json([
                    'message' => 'Method not allowed. Use POST /api/login.',
                ], 405);
            }

            return response()->json([
                'message' => 'Method not allowed.',
            ], 405);
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if (! ($request->is('api/*') || $request->expectsJson())) {
                return null;
            }

            return response()->json([
                'message' => $e->getMessage() ?: 'Unauthenticated.',
            ], 401);
        });

        $exceptions->render(function (ValidationException $e, Request $request) {
            if (! ($request->is('api/*') || $request->expectsJson())) {
                return null;
            }

            return response()->json([
                'message' => $e->getMessage() ?: 'The given data was invalid.',
                'errors' => $e->errors(),
            ], $e->status);
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            if (! ($request->is('api/*') || $request->expectsJson())) {
                return null;
            }

            $status = 500;
            $debug = config('app.debug');

            $payload = [
                'message' => $debug ? $e->getMessage() : 'Server error.',
            ];

            if ($debug) {
                $payload['exception'] = class_basename($e);
            }

            return response()->json($payload, $status);
        });
    })->create();
