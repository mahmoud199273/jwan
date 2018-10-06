<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Campaign;
use App\Complaint;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }


    public function index()
    {
    	$users  		= User::where('account_type','0')->count();
    	$influencers 	= User::where('account_type','1')->count();
        $campaigns      = Campaign::count();
    	$complaints 	= Complaint::count();
        return view('admin.dashboard.index', compact('users', 'influencers', 'campaigns', 'complaints'));
    }
}
