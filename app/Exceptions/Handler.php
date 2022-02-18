<?php

namespace App\Exceptions;

use App\Http\Services\RestService;
use Cassandra\Exception\ValidationException;
use HttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Env;
use Illuminate\Support\Traits\EnumeratesValues;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

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

    public function render($request, Throwable $e)
    {
        if(($request->ajax() && !$request->pjax()) || $request->wantsJson()) {
            if($e instanceof ValidationException) {
                if(Env("APP_DEBUG")==true){
                    return (new RestService())->setErrors(\Illuminate\Support\Arr::collapse($e->errors()))->setSuccess(false)->setStatus(422)->build();
                }else {
                    return (new RestService())->setErrors("Validation error")->setSuccess(false)->setStatus(422)->build();
                }
            }
        }
        if(!empty($e->getMessage())){
            if(Env("APP_DEBUG")==true) {
                return (new RestService())->setSuccess(false)->setErrors($e->getMessage())->setStatus(500)->build();
            }else{
                return (new RestService())->setSuccess(false)->setErrors("Internal server error")->setStatus(500)->build();
            }
        }else{
            return (new RestService())->setSuccess(false)->setErrors('Page not found')->setStatus(404)->build();
        }
    }
}
