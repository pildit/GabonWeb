<?php

namespace App\Exceptions;

use Exception;
use GenTux\Jwt\Exceptions\JwtException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        logger()->warning($exception->getMessage());
        logger()->warning('headers: '.json_encode($request->headers->all()));
        logger()->warning('body: '.json_encode($request->attributes));
        logger()->warning('url: '.json_encode($request->fullUrl()));

        if ($exception instanceof ModelNotFoundException) {
            $model = explode("\\", $exception->getModel());
            $model = end($model);
            return response()->json([
                'message' => 'Entry for '.$model.' not found'
            ], 404);
        }

        if ($exception instanceof QueryException) {
            return response()->json([
                'message' => "There is database problem: ".$exception->getMessage()
            ], 500);
        }

        if($exception instanceof AuthorizationException) {
            return response()->json([
                'message' => "This action is unauthorized."
            ],403);
        }

        if ($exception instanceof JwtException) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 401);
        }

        // If the request is JSON
        if ($request->isJson() && ($this->isHttpException($exception))) {
            $message = ($exception->getMessage()) ? : 'Not Found.';
            return response()->json([
                'message' => $message
            ], $exception->getStatusCode());
        }


        return parent::render($request, $exception);
    }
}
