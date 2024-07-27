<?php

namespace App\Exceptions;

use App\Http\Controllers\ApiController;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Throwable;


class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = ['current_password', 'password', 'password_confirmation'];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            $apiController = new ApiController();

            if ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException)
                return $apiController->notFoundMessage();

            if ($e instanceof TooManyRequestsHttpException)
                return $apiController->manyRequestMessage();

            if ($e instanceof AuthenticationException)
                return $apiController->unauthorizedMessage();

//            if ($e instanceof CafearzException)
//                return $apiController->errorMessage($e->getMessage());
//
//            if ($e instanceof SecureTokenException)
//                return $apiController->errorMessage($e->getMessage(), 423);

            if ($e instanceof ValidationException)
                return $apiController->respond(['message' => $e->errors()], 422);

//            if ($e instanceof MethodNotAllowedHttpException)
//                return $apiController->notSupportMethodRoute();

        });
    }
}
