<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * @param  Request $request
     * @return string|void
     */
    protected function redirectTo($request)
    {
        if ($request->expectsJson() === false) {
            return route('login');
        }
    }
}
