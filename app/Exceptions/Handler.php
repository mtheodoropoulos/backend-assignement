<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
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
        'current_password',
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception )
    {
        if ($request->expectsJson()){

            if ($exception instanceof MethodNotAllowedHttpException ) {
                return response()->json([
                    'success'=>false,
                    'error' => 'Error',
                    'message'=>'Method Not Allowed'
                ], 405);
            }
    
            if ($exception instanceof AuthorizationException) {
                return response()->json([
                    'success'=>false,
                    'error' => 'Unauthorised',
                    'message'=>'Action Unauthorised'
                ], 403);
            }
    
            if ($exception instanceof HttpResponseException) {
                return response()->json([
                    'success'=>false,
                    'error' => 'Unauthorised',
                    'message'=>'Action Unauthorised'
                ], 403);
            }
    
            if ($exception instanceof ModelNotFoundException ) {
                return response()->json([
                    'success'=>false,
                    'error' => 'error',
                    'message'=>'Model Not Found'
                ], 404);
            }
    
            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'success'=>false,
                    'error' => 'Not Found',
                    'message'=>'Resource not found'
                ], 404);
            }
            if ($exception instanceof PDOException ) {
                return response()->json([
                    'success'=>false,
                    'error' => 'No query results',
                    'message'=> $exception->getMessage()
                ], Response::HTTP_BAD_REQUEST);
            }

        }

        return parent::render($request, $exception);

    }
}
