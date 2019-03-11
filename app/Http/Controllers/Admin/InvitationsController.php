<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Invitations;
use App\Models\InvitationCodes;

class InvitationsController extends Controller
{

    function __construct(){
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $invitations = Invitations::paginate(10);
        return view('admin.invitations.index',compact("invitations"));
    }

    public function search( Request $request ){
        $query =  $request->q;
        if ( $query == "") return redirect()->back(); 
        else{
            $invitations = Invitations::
                                        where('phone', 'LIKE', '%'.$query.'%')
                                        ->orWhere('email', 'LIKE', '%'.$query.'%')
                                        ->paginate(10);
            $invitations->appends( ['q' => $request->q] );
            if (count ( $invitations ) > 0) return view('admin.invitations.index',[ 'invitations' => $invitations ])->withQuery($query);
            else return view('admin.invitations.index',[ 'invitations'=>null ,'message' => __('admin.no_result') ]);
            
        }
    }

 


}
