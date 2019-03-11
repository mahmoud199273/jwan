<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\User\EditUserRequest;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Models\Invitations;
use App\User;
use App\UserPlayerId;
use App\VerifyPhoneCode;
use Illuminate\Http\Request;


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
    public function index()
    {
        $invitations = Invitations::all();
        $users = User::select('users.*','v.code','v.verified')
        ->LEFTJOIN(DB::raw('(SELECT phone, max(id) as mx from verify_phone_codes GROUP BY phone) as v2'), 
        function($join)
        {
            $join->on('users.phone', '=', 'v2.phone');
        })
        ->leftJoin('verify_phone_codes as v', function($join)
        {
            $join->on('v.id', '=', 'v2.mx');
            $join->on('v.phone','=','v2.phone');
        })->where('users.account_type','0')->latest()->paginate(10);
        return view('admin.invitations.index',compact('users', "invitations"));
    }

       public function search( Request $request )
    {
        $query =  $request->q;
        
        if ( $query == "") {
            return redirect()->back();
        }else{

             /*$users   = User::where([['name', 'LIKE', '%' . $query. '%'],
                                            ['account_type','0']] )
                                     ->orWhere([['phone', 'LIKE', '%' . $query. '%'],
                                        ['account_type','0']] )*/

             $users   = User::select('users.*','v.code','v.verified')
                                    ->LEFTJOIN(DB::raw('(SELECT phone, max(id) as mx from verify_phone_codes GROUP BY phone) as v2'), 
                                    function($join)
                                    {
                                        $join->on('users.phone', '=', 'v2.phone');
                                    })
                                    ->leftJoin('verify_phone_codes as v', function($join)
                                    {
                                        $join->on('v.id', '=', 'v2.mx');
                                        $join->on('v.phone','=','v2.phone');
                                    })
                                     ->where([['users.name', 'LIKE', '%' . $query. '%'],['users.account_type','0']] )
                                     ->orWhere([['users.phone', 'LIKE', '%' . $query. '%'],['users.account_type','0']] )
                                     ->orWhere([['users.email', 'LIKE', '%' . $query. '%'],['users.account_type','0']] )
                                     ->groupBy('users.phone')
                                     ->paginate(10);
            $users->appends( ['q' => $request->q] );
            if (count ( $users ) > 0){
                return view('admin.users.index',[ 'users' => $users ])->withQuery($query);
            }else{
                return view('admin.users.index',[ 'users'=>null ,'message' => __('admin.no_result') ]);
            }
            //dd($users);
        }
    }

 


}
