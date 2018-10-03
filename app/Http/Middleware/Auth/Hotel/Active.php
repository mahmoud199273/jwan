<?php

namespace App\Http\Middleware\Auth\Hotel;

use Closure;
use Illuminate\Auth\AuthenticationException;

class Active
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
        $this->auth = auth()->guard('hotel');
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
       $activation = $this->auth->user()->activation;
       if ($activation == 2 || $activation == 3){
            session()->flash('notice',trans('lang.Your profile not activated yet, You can complete your profile till get activated.'));
           return redirect("hotel-dashboard/profile?page=base_info");
       }

        return $next($request);
    }






}
