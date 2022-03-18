<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $e): Response|JsonResponse|HttpFoundationResponse
    {
        if ($request->is('api/*')) {
            $errorResponse = [
                'error' => true,
                'message' => $e->getMessage()
            ];

            if ($e instanceof NotFoundHttpException) {
                $errorResponse['message'] = 'Route not found!';
            }

            return response()->json($errorResponse);
        }

        return parent::render($request, $e);
    }
}
