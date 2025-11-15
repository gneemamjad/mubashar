<?php

namespace App\Exceptions;

use App\Helpers\ResponseCode;
use App\Traits\Response as TraitsResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    use TraitsResponse;
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {

        if ($e instanceof ValidationException) {
            if (request()->is('admin/*') || request()->is('admin')) 
                return redirect()->back()->withErrors($e->errors());
        }
        if ($e instanceof \Illuminate\Auth\AuthenticationException) {
            if (request()->is('admin/*') || request()->is('admin')) {
                return redirect()->route('admin.login');
            }
            return $this->unauthenticatedResponse();
        }
        return parent::render($request, $e);
    }
}
