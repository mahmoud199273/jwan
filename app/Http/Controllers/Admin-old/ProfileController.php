<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ProfileController extends Controller
{

    function __construct()
    {
        $this->middleware(function($request, $next){
            $this->auth = auth()->guard('admin')->user();
            return $next($request);
        });
    }

    public function getIndex()
    {
    	$user = $this->auth;
    	return view('admin.profile',compact('user'));
    }

    public function postIndex()
    {
    	$user = $this->auth;
    	$this->validate(request(),[
    			'name'=>'required',
    			'email'=>'required|email|unique:admins,email,'.$user->id,
    			'image'=>'image',
    			'password'=>'confirmed|min:6'
    		]);
    	if (request()->has('password'))
	    	$user = $user->update(request()->all());
    	else
	    	$user = $user->update(request()->except('password'));
    	return back()->withSuccess(trans('lang.updatedsuccessfully'));
    }
}
