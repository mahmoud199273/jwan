<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Nathionality;

class TestController extends Controller
{
    //

     function __construct(){
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $rows = Nathionality::latest()->paginate(10);
        return view('admin.natoinalities.index',compact('rows'));
    }


    


}
