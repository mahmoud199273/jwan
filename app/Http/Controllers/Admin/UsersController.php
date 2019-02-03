<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\User\EditUserRequest;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\User;
use App\UserPlayerId;
use App\VerifyPhoneCode;
use Illuminate\Http\Request;


class UsersController extends Controller
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
        $notification   = User::where('is_active','0')->count();
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
        return view('admin.users.index',compact('users','notification'));
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

 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries =  Country::all();
        return view('admin.users.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $request->persist();
        $code = rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9);
        $phone = $request->phone;
        $verify = new VerifyPhoneCode;
        $verify->phone = $phone;
        $verify->account_type = '0';
        $verify->code = $code;
        $verify->verified = '1';
        $verify->save();

        // dd($verify);

        return redirect()->back()->with('status' , __('admin.created') );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //dd($id);
        $user = User::find($id);
        //dd($user);
        $countries =  Country::all();
        return view('admin.users.show',compact('user','countries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $countries =  Country::all();

        return view('admin.users.edit',compact('user','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, $id)
    {
        $request->persist($id);
        return redirect()->back()->with('status' , __('admin.updated') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            User::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }


    public function activate( Request $request)
    {
        if ( $request->ajax() ) {
            $user = User::find( $request->id );
            $user->is_active = '1';
            $user->save();
            return response(['msg' => 'activated', 'status' => 'success']);
        }

        
    }

    public function getUserPlayerIds( $user_id )
    {
        $player_ids = UserPlayerId::where('user_id',$user_id)->pluck('player_id')->toArray();
        return $player_ids ? $player_ids : null;
    }

    public function ban( Request $request )
    {
        $user =  User::find( $request->id );
        if ( $request->ajax() ) {
            $user->is_active = '0';
            $user->save();

            $player_ids = $this->getUserPlayerIds($user->id);
            sendNotification(1,'Your account is suspended,please refer to the admin ','تم ايقاف العضوية برجاء الرجوع الى الادارة',$player_ids,"public",['user_id' =>  (int)$user->id,'type'=>  13,'type_title'	=> 'logout ']);

            return response(['msg' => 'banned', 'status' => 'success']);
        }

    }

    public function unblock(Request $request)
    {
        $user =  User::find( $request->id );
        if ( $request->ajax() ) {
            $user->login_attempts = '0';
            $user->block = '0';
            $user->block_time = NULL;
            $user->save();

           
            return response(['msg' => 'unblocked', 'status' => 'success']);
        }
    }

}
