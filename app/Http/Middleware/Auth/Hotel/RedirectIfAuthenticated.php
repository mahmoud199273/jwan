<?php

namespace App\Http\Middleware\Auth\Hotel;

use Closure;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->guard('hotel')->check()) {
            return redirect(HOTEL_DASHBOARD);
        }

        return $next($request);
    }
}
