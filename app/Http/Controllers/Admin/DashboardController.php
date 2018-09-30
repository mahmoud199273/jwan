<?php

namespace App\Http\Controllers\Admin;

use App\Ad;
use App\Http\Controllers\Controller;
use App\Subscription;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }


    public function index()
    {
    	$users  		= User::where('type','user')->count();
    	$offices 		= User::where('type','office')->count();
        $ads            = Ad::where('is_paid', '0')->count();
    	$featured_ads   = Ad::where('is_paid', '1')->count();
    	$subscriptions 	= Subscription::count();
        return view('admin.dashboard.index', compact('users', 'offices', 'ads', 'featured_ads', 'subscriptions'));
    }
}
