<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class TestController extends Controller
{
    //

    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index',compact('users'));
    }

}
