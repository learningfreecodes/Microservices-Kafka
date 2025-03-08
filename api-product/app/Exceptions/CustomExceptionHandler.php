<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use KeycloakGuard\Exceptions\TokenException as TokenExceptionAlias;
use Throwable;

class CustomExceptionHandler extends ExceptionHandler
{
    // Implement the render method to handle exceptions
    public function render($request, Throwable $e)
    {
        // Check if the exception is of type TokenException
        if ($e instanceof TokenExceptionAlias) {
            // Return a custom JSON response
            return response()->json([
                'message'   => 'Unauthorized',
                'exception' => 'KeycloakGuard\\Exceptions\\TokenException',
                'description' => $e->getMessage(),
//                'file'      => $exception->getFile(),
//                'line'      => $exception->getLine(),
//                'trace'     => $exception->getTrace(),
            ], 401);
        }

        // For other exceptions, let Laravel handle them
        return parent::render($request, $e);
    }
}
