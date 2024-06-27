<?php

namespace App\Exceptions;

use App\Dto\Dto;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
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
        $this->renderable(function (NotFoundHttpException $e) {
            return Dto::error(Response::HTTP_NOT_FOUND, $e->getMessage());
        });

        $this->renderable(function (AuthenticationException $e) {
            return Dto::error(Response::HTTP_UNAUTHORIZED, $e->getMessage());
        });

        $this->renderable(function (AccessDeniedHttpException $e) {
            return Dto::error(Response::HTTP_FORBIDDEN, $e->getMessage());
        });

        $this->renderable(function (ConflictHttpException $e) {
            return Dto::error(Response::HTTP_CONFLICT, $e->getMessage());
        });

        $this->renderable(function (BadRequestHttpException $e) {
            return Dto::error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        });

        $this->renderable(function (Throwable $e) {
            $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
            $method = isset($trace[1]['class']) ? "\nCONTROLLER::method >>> " . $trace[1]['function'] : 'Unknown' . "\n\n";
            Log::error('Exception in ' . $method . ': ' . $e->getMessage());

            return Dto::error(Response::HTTP_INTERNAL_SERVER_ERROR, 'Server error, please try again later');
        });
    }
}
