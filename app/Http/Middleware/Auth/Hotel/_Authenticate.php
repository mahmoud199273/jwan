<?php

namespace App\Http\Middleware\Auth\Hotel;

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
        if ($this->auth->check())
        {
           return $this->redirect($this->checkIfHasAccess($this->auth),$request,$next);
        }

        return $this->redirect(false,$request, $next);
    }


    public function redirect($status, $request, Closure $next)
    {
        if ($status == 2){
            if ($request->path() !=  HOTEL_DASHBOARD.'/profile')
                    return redirect("hotel-dashboard/profile?page=base_info");
        }
        elseif($status == 3){
            return redirect()->guest(HOTEL_DASHBOARD.'/login')->withFailed(trans('lang.Your account Is disable !'));
        }
        if ($status == 0) {
            if ($request->ajax())
            {
                return response('Unauthorized.', 401);
            }
            else
            {
                return redirect()->guest(HOTEL_DASHBOARD.'/login');
            }
        }
        return $next($request);
    }

    public function checkIfHasAccess($user)
    {
        $activation = $user->user()->activation;
        if ($activation == 1) {
            return 1; // pass
        }elseif($activation == 2) {
            session()->flash('notice',trans('lang.Your profile not activated yet, You can complete your profile till get activated.'));
            return 2; // pending
        }
        # account deactivated
        $this->auth->logout();
        return 0 ; // deactivated
    }

}

/*
$total_keys = 0 ;
$total_empty = 0;
$f = array_filter($user->user()->detail->toArray());
dd(count($f));
$filter = array_filter($user->user()->detail->toArray(), function($value,$key) use($total_keys, $total_empty){
    $total_keys++;
    if (empty($value) || is_null($value))
        $total_empty++;
},ARRAY_FILTER_USE_BOTH);
$compliation_percentage = $total_empty / $total_keys * 100;
            dd($compliation_percentage);
 */
