<?php

namespace App\Http\Middleware\Auth\Admin;

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
        if (auth()->guard('admin')->check()) {
            return redirect(ADMIN_PATH);
        }

        return $next($request);
    }
}
