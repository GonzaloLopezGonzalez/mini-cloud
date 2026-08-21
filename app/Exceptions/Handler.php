<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render(Request $request, Throwable $exception)
    {
        // Manejo de error 404
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->view('errors.404', ['message' => $exception->getMessage()], 404);
        }

        // Manejo de error 403
        if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return response()->view('errors.403', ['message' => $exception->getMessage()], 403);
        }

        // Manejo de error 419 (CSRF)
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            return response()->view('errors.419', ['message' => 'La sesión ha expirado'], 419);
        }

        // Manejo de error 500
        if ($exception instanceof \Exception) {
            return response()->view('errors.500', ['message' => $exception->getMessage()], 500);
        }

        return parent::render($request, $exception);
    }
}