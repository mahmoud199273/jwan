<?php

namespace App\Http\Controllers\Auth\Admin;
use App\Http\Controllers\Controller;

/**
* Authentication Extender
*/
class AuthenticationController extends Controller
{
	
	protected $auth_name = 'admin';
     /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = ADMIN_PATH;
}