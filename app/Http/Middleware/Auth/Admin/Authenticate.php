<?php

namespace App\Http\Middleware\Auth\Admin;

use Closure;
use Illuminate\Auth\AuthenticationException;

class Authenticate
{
    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->auth = auth()->guard('admin');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next)
    {

        if ($this->auth->check())
        {
           return $this->redirect($this->checkIfHasAccess(),$request,$next);
        }
        return $this->redirect(false,$request, $next);
    }


    public function redirect($response, $request, Closure $next)
    {
        if (!$response) {
            if ($request->ajax())
            {
                return response('Unauthorized.', 401);
            }
            else
            {
                return redirect()->guest(ADMIN_PATH.'/login');
            }
        }
        return $next($request);
    }

    public function checkIfHasAccess()
    {
        $activation = $this->auth->user()->activation;
        if ($activation) {
            return true;
        }
        $this->auth->logout();
        return redirect()->guest(ADMIN_PATH.'/login')->withFailed(trans('lang.Your account Is disable !'));
    }

}
