<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string|null  ...$guards
     *
     * @return Response
     */
    public function handle(
        Request $request,
        Closure $next,
        ...$guards
    ): Response {
        $guards = empty($guards) === true ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check() === true) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
