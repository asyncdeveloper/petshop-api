<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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
        $this->renderable(function (TokenInvalidException $e, $request) {
            return Response::json(['message' => 'Invalid token'], 401);
        });
        $this->renderable(function (TokenExpiredException $e, $request) {
            return Response::json(['message' => 'Token has Expired'], 401);
        });

        $this->renderable(function (JWTException $e, $request) {
            return Response::json(['message' => 'Token not parsed'], 401);
        });

        $this->renderable(function (NotFoundHttpException $exception, $request) {
            return Response::json([ 'message' => 'Resource not found' ], 404);
        });
    }
}
