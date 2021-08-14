<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // TODO: React when any exception is thrown as all exceptions implement Throwable
            // See https://laravel.com/docs/8.x/errors#reporting-exceptions
        });
    }
}
