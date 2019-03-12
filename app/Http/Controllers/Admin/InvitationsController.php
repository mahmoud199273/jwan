<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Invitations;
use App\Models\InvitationCodes;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper as responseHelper;

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

    public function invitationCodes(){
        $invitations = InvitationCodes::paginate(10);
        return view('admin.invitations.invitationCodes',compact("invitations"));
    }

    public function addInvitaionCodeView(){
        return view('admin.invitations.create');
    }

    public function store(Request $request){
        $rules = [ 
            'code' => 'required|regex:/^[a-zA-Z0-9]{4}/',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) return responseHelper::Fail("validationError",$validator->messages());

        $trytofind = InvitationCodes::where("code",$request->code)->first();
        if($trytofind) return redirect()->back()->with('status' , __('admin.created') );
        // return responseHelper::Fail("validationDublicationError",["message" => "this code was added before."]);

        $res = InvitationCodes::create(["code" => $request->code, "status"=> "ACTIVE"]);
        // return responseHelper::Success("created",["message" => "invitation code request was added."]);
        return redirect()->back()->with('status' , __('admin.created') );
    }

}
