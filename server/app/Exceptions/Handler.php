<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $exception) {
            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'status' => [
                        'code' => Response::HTTP_NOT_FOUND,
                        'description' => 'Route not found'
                    ]
                ], Response::HTTP_NOT_FOUND);
            }

            if ($exception instanceof AuthenticationException) {
                return response()->json([
                    'status' => [
                        'code' => Response::HTTP_UNAUTHORIZED,
                        'description' => 'Unauthenticated'
                    ]
                ], Response::HTTP_UNAUTHORIZED);
            }

            $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
            $method = isset($trace[1]['class']) ? $trace[1]['class'] . '::' . $trace[1]['function'] : 'Unknown';
            Log::error('Exception in ' . $method . ': ' . $exception->getMessage());
            return response()->json([
                'status' => [
                    'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'description' => 'Server error, please try again later'
                ]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    }
}
