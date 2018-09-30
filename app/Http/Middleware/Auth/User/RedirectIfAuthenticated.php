<?php

namespace App\Http\Middleware\Auth\User;

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
        if (auth()->guard('user')->check()) {
            return redirect('/');
        }

        return $next($request);
    }
}
