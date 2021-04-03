<?php

namespace App\Exceptions;

use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return JsonResponse
     */
    public function render($request, Throwable $e): JsonResponse
    {
        switch (true) {
            case $e instanceof ModelNotFoundException:
                return $this->response('Record not found', null, 404, 'error');
            case $e instanceof NotFoundHttpException:
                return $this->response('Not found', null, 404, 'error');
            case $e instanceof ValidationException:
                /** @var Validator $validator */
                $validator = $e->validator;

                return $this->response(collect($validator->messages()->all())->implode(', '), null, ErrorCodes::VALIDATION_ERROR, 'error');
            default:
                return $this->response($e->getMessage(), null, $this->getErrorCode($e), 'error', $e->getTrace());
        }
    }

    /**
     * @param Throwable $exception
     * @return int
     */
    private function getErrorCode(Throwable $exception): int
    {
        return (int) $exception->getCode() !== 0 ? (int) $exception->getCode() : ErrorCodes::DEFAULT_ERROR;
    }
}
