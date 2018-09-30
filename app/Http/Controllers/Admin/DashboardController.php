<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\Admin\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function index()
    {
        $users  = User::where('type', 1)->count();
       
        $year = date('Y');
        $month = date('m');
        $date = date('Y-m-d');
        return view('admin.index', compact('users'));
    }


}
