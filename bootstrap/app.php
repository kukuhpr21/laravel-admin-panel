<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Application;
use App\Http\Middleware\EnsurePermissionIsValid;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias(['permissionIsValid' => EnsurePermissionIsValid::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($e instanceof HttpExceptionInterface) {
                $statusCode = $e->getStatusCode();
            } else {
                $statusCode = 500; // Default for non-HTTP exceptions
            }

            $messages = [
                400 => 'Bad Request',
                401 => 'Unauthorized',
                402 => 'Payment Required',
                403 => 'Forbidden',
                404 => 'Page Not Found',
                405 => 'Method Not Allowed',
                500 => 'Server Error',
            ];

            $message = $messages[$statusCode] ?? 'An unexpected error occurred';

            return response()->view('errors.error', [
                'code' => $statusCode,
                'message' => $message,
            ], $statusCode);
        });
    })->create();
