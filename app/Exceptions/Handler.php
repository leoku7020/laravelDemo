<?php

namespace App\Exceptions;

use App\Formatters\ApiOutput;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
        \Illuminate\Validation\ValidationException::class,
        \Illuminate\Http\Exceptions\ThrottleRequestsException::class,
    ];

    protected $customExceptions = [
        ErrorException::class,
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
        if ($this->isNotFoundException($exception)
            || $exception instanceof ValidationException
            || $this->isAPICustomException($exception)) {
            return;
        }

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
        $formatter = app(ApiOutput::class);

        if ($this->isNotFoundException($exception)) {
            $this->setLog($request, Response::HTTP_NOT_FOUND, 'Page not found');
            return response()->json(
                $formatter->failFormat('Page not found', Response::HTTP_NOT_FOUND),
                Response::HTTP_NOT_FOUND
            );
        }

        if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            return response()->json(
                $formatter->failFormat('token_expired', Response::HTTP_UNAUTHORIZED),
                Response::HTTP_UNAUTHORIZED
            );
        }

        if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
            $this->setLog($request, $exception->getCode(), $exception->getMessage());
            return response()->json(
                $formatter->failFormat('token_blacklisted', Response::HTTP_FORBIDDEN),
                Response::HTTP_FORBIDDEN
            );
        }

        if ($exception instanceof TokenException) {
            return response()->json(
                $formatter->failFormat($exception->getMessage(), $exception->getCode()),
                $exception->getCode()
            );
        }

        if ($exception instanceof ValidationException) {
            $this->setLog(
                $request,
                Response::HTTP_UNPROCESSABLE_ENTITY,
                'The given data was invalid.',
                $exception->validator->errors()
            );
            return response()->json(
                $formatter->failFormat(
                    'The given data was invalid.',
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    $exception->validator->errors()
                )
            );
        }

        if ($exception instanceof ThrottleRequestsException) {
            return response()->json(
                $formatter->failFormat(
                    __('system.tooManyRequest'),
                    129
                )
            );
        }

        if ($this->isAPICustomException($exception)) {
            $this->setLog($request, $exception->getCode(), $exception->getMessage());
            return response()->json(
                $formatter->failFormat(
                    $exception->getMessage(),
                    $exception->getCode()
                )
            );
        }

        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }
        $this->setLog(
            $request,
            Response::HTTP_INTERNAL_SERVER_ERROR,
            empty($exception->getMessage()) ? 'Oops! Something went wrong.' : $exception->getMessage()
        );
        return response()->json(
            $formatter->failFormat(
                empty($exception->getMessage()) ? 'Oops! Something went wrong.' : $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            ),
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    protected function isNotFoundException($exception)
    {
        return $exception instanceof NotFoundHttpException || $exception instanceof MethodNotAllowedHttpException;
    }

    protected function isAPICustomException(Exception $e)
    {
        foreach ($this->customExceptions as $customException) {
            if ($e instanceof $customException) {
                return true;
            }
        }
        return false;
    }

    protected function setLog($request, $code, $message, $errors = [])
    {
        $params = [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'api_method' => $request->method(),
            'api_url' => $request->url(),
            'api_header' => $request->header(),
            'api_input_params' => $request->all(),
            'api_output' => [
                'code' => $code,
                'message' => $message,
                'errors' => $errors,
            ]
        ];
        Log::info(var_export($params, true));
    }
}
