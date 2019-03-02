<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\User\EditUserRequest;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\User;
use App\UserSocial;
use App\UserPlayerId;
use App\Nathionality;
use App\VerifyPhoneCode;
use Illuminate\Http\Request;


class InfluencersController extends Controller
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
        $users = User::where('is_active','0')->count();
        $users = User::select('users.*','v.code','v.verified','user_socials.id as social_id')
        ->LEFTJOIN('user_socials','user_socials.user_id','users.id')
        ->LEFTJOIN(DB::raw('(SELECT phone, max(id) as mx from verify_phone_codes GROUP BY phone) as v2'),
        function($join)
        {
            $join->on('users.phone', '=', 'v2.phone');
        })
        ->leftJoin('verify_phone_codes as v', function($join)
        {
            $join->on('v.id', '=', 'v2.mx');
            $join->on('v.phone','=','v2.phone');
        })->where('users.account_type','1')->latest()->paginate(10);
        return view('admin.influencers.index',compact('users'));
    }

       public function search( Request $request )
    {
        $query =  $request->q;

        if ( $query == "") {
            return redirect()->back();
        }else{
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
                                     })->where([['users.name', 'LIKE', '%' . $query. '%'],['users.account_type','1']] )
                                     ->orWhere([['users.phone', 'LIKE', '%' . $query. '%'],['users.account_type','1']] )
                                     ->orWhere([['users.email', 'LIKE', '%' . $query. '%'],['users.account_type','1']] )
                                     ->paginate(10);
            $users->appends( ['q' => $request->q] );
            if (count ( $users ) > 0){
                return view('admin.influencers.index',[ 'users' => $users ])->withQuery($query);
            }else{
                return view('admin.influencers.index',[ 'users'=>null ,'message' => __('admin.no_result') ]);
            }
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
        $nationalities =  Nathionality::all();
        return view('admin.influencers.create',compact('countries','nationalities'));
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
        $verify->account_type = '1';
        $verify->code = $code;
        $verify->verified = '1';
        $verify->save();

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
        $user = User::find($id);
        $countries =  Country::all();
        $nationalities =  Nathionality::all();
        return view('admin.influencers.show',compact('user','countries','nationalities'));
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
        $nationalities =  Nathionality::all();
        return view('admin.influencers.edit',compact('user','countries','nationalities'));
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
         $user = User::find($id);
         // dd($user->phone);
        $request->persist($id);
        $code = rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9);
        $phone = $request->phone;
        if($user->phone !=$phone ){
            $verify = new VerifyPhoneCode;
            $verify->phone = $phone;
            $verify->account_type = '1';
            $verify->code = $code;
            $verify->verified = '1';
            $verify->save();
        }


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
            $user->class = $request->class;
            $user->save();

            @sendSMS($this->formatPhone($user->phone,$user->countries_id) , __('api_msgs.active_sms'));
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

    public function InfluencerSocial ($id)
    {
        $row = UserSocial::where('user_id',$id)->first();
        return view('admin.influencers.social',compact('row'));
    }
    public function UpdateInfluencerSocial (Request $request , $id)
    {
      //ssssssssss
        $user_social = UserSocial::where('id',$id)->first();
        if($user_social)
        {
        $player_ids = $this->getUserPlayerIds($user_social->user_id);
        dd($player_ids);
          if($request->approve=="approve")
          {
              $user =  User::find( $user_social->user_id );
              $user->facebook = $user_social->facebook;
              $user->facebook_follwers = $user_social->facebook_follwers;
              $user->twitter = $user_social->twitter;
              $user->twitter_follwers = $user_social->twitter_follwers;
              $user->instgrame = $user_social->instgrame;
              $user->instgrame_follwers = $user_social->instgrame_follwers;
              $user->snapchat = $user_social->snapchat;
              $user->snapchat_follwers = $user_social->snapchat_follwers;
              $user->linkedin = $user_social->linkedin;
              $user->linkedin_follwers = $user_social->linkedin_follwers;
              $user->youtube = $user_social->youtube;
              $user->youtube_follwers = $user_social->youtube_follwers;
              $user->save();
              sendNotification(1,'Your social media details update has been approved','تم الموافقة على تحديث بيانات مواقع التواصل الخاصة بك',$player_ids,"",[/*'user_id' =>  (int)$user->id,'type'=>  13,'type_title'	=> 'logout '*/]);
          }
          else
          {
            sendNotification(1,'Your social media details update has been rejected','تم رفض طلبك على تحديث بيانات مواقع التواصل الخاصة بك',$player_ids,"",[/*'user_id' => (int)$user->id,'type'=> 13,'type_title' => 'logout '*/]);
          }
          UserSocial::where('id',$id)->delete();
        }
        return redirect()->intended(config('app.admin_url').'/influencers');
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
