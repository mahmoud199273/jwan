<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as Controller;
use App\User;
use App\UserCategory;
use App\UserCountry;
use App\UserArea;
//use App\UserPlayerId;
//use App\VerifyPhoneCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use JWTAuth;
use Response;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{


  	function __construct( Request $request ){

        App::setlocale($request->lang);
  		$this->middleware('jwt.auth')->only(['logout']);

  	}


	/*
    *public function sendCode( Request $request )
	{
		$validator = Validator::make( $request->all(), [
            'phone'  => 'required|max:16|min:9',
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.enter_valid_phone'));
        }


        if ($this->isPhoneExists( $request->phone )) {
           return $this->setStatusCode(422)->respondWithError(trans('api_msgs.phone_exists'));
        }

        //create verfication code
        $this->createVerificationCode( arTOen($request->phone) );


        return $this->respondCreated(trans('api_msgs.code_sent'));
	}*/




    /*
    *public function formatPhone( $phone )
    {
	$is_valid_phone = preg_match('/^(9665|\9665|05)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/', $phone);
        if ($is_valid_phone) {
            if (strncmp($phone, "966", 3) === 0) {
                return $phone;
            }else{
                return substr_replace($phone , '966', 0 , 1 );
            }
        }

        return false;
    }*/


	/*
    *public function createVerificationCode( $phone )
    {
        $verify_code    = rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9);
        $current_time   = Carbon::now();
        $created_at     = $current_time->toDateTimeString();
        $expired_at     = $current_time->addHours(24)->toDateTimeString();
        DB::table('verify_phone_codes')->insert([
		         'phone'         => $phone ,
                   'code'          => $verify_code ,
		         'created_at'    => $created_at,
		        'expired_at'    => $expired_at
	                                            ]);
        //send message to mobile
       // @sendSMS($phone , __('api_msgs.sms_code_text').$verify_code );
    }*/


    public function isPhoneExists( $phone )
    {
        return User::where('phone',$phone)->first() ? true : false;
    }

    /*public function isEmailExists( $email )
    {
        return User::where('email',$email)->first() ? true : false;
    }*/





    /*
    *public function verifyCode( Request $request )
    {

    	$validator = Validator::make( $request->all(), [
            'code'                  => 'required|max:4|min:4',
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        $code	= VerifyPhoneCode::where([ [ 'code', arTOen($request->code) ],[ 'verified', '0'] ])->first();

        if ( !$code ) {

            return $this->setStatusCode(404)->respondWithError(trans('api_msgs.invalid_code'));
        }

        $user  =  User::where('phone', $code->phone)->first();

        if ($user) {

            $token = JWTAuth::fromUser($user);

        }else{

            return $this->setStatusCode(404)->respondWithError(trans('api_msgs.invalid_code'));
        }

        $current    = strtotime(Carbon::now()->toDateTimeString());
        $expired_at = strtotime($code->expired_at);

        if ( $expired_at < $current or $expired_at == $current )  {

            return $this->setStatusCode(404)->respondWithError(trans('api_msgs.invalid_code'));

        }else{
        	$code->verified = '1';
            $code->save();
            $user->is_active = '1';
            $user->save();
            return $this->respond(['token' => $token ]);
        }


    }*/


    public function register( Request $request )
    {
        // dd(App::getLocale());
    	$validator = Validator::make( $request->all(), [

            'email'         => 'required',

            'phone'			=> 'required|max:14|min:9',

            'countries_id'    => 'required',

            'password'		=> 'required|string|max:25|min:8',

            'image'         => 'required',

            'name'          => 'required|string|max:25|min:2',

            'notes'         => 'required',

            'type'          => 'required',

            'facebook'      => 'nullable',

            'facebook_followers' => 'nullable',

            'twitter' => 'nullable',

            'twitter_followers' => 'nullable',

            'instagram' => 'nullable',

            'instagram_followers' => 'nullable',

            'snapchat' => 'nullable',

            'snapchat_followers' => 'nullable',

            'linkedin' => 'nullable',

            'linkedin_followers' => 'nullable',

            'youtube'       => 'nullable',

            'youtube_followers' => 'nullable'



        ]);

        if ($this->isPhoneExists( $request->phone )) {
           return $this->setStatusCode(422)->respondWithError(trans('api_msgs.phone_exists'));
        }



        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages());
            // return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }




			$user = new User();


            $user->phone        =  $request->phone;

            $user->email        =  $request->email;

            $user->password     =  bcrypt($request->password);

            $user->image       = $request->image;

            $user->name         =  $request->name;

            $user->notes             = $request->notes;

            $user->type              = $request->type;

            $user->facebook          = $request->facebook;

            $user->facebook_followers  = $request->facebook_followers;

            $user->twitter            = $request->twitter;

            $user->twitter_followers   = $request->twitter_followers;

            $user->instagram           = $request->instagram;

            $user->instagram_followers  =$request->instagram_followers;

            $user->snapchat            = $request->snapchat;

            $user->snapchat_followers   = $request->snapchat_followers;

            $user->linkedin             = $request->linkedin;

            $user->linkedin_followers   = $request->linkedin_followers;

            $user->youtube             = $request->youtube;

            $user->youtube_followers   = $request->youtube_followers;

            $user->countries_id    = $request->countries_id;
            $user->account_type = 0;
            $user->is_active    =  '1';
			      $user->save();

           // $this->createVerificationCode( arTOen($request->phone) );

            $token = JWTAuth::fromUser($user);

            return Response::json( compact('token'));

            //return $this->respondCreated(trans('api_msgs.success'));




    }

    public function registerInfluncer( Request $request )
    {

        $validator = Validator::make( $request->all(), [

            'email'         => 'required|unique:users,email',

            'phone'         => 'required|max:14|min:9',

            'password'      => 'required|string|max:25|min:8',

            'image'         => 'required',

            'name'          => 'required',

            'gender'        => 'required',

            'nationality_id'   => 'required',

            'notes'          => 'required',

            'account_manger' => 'required',



            'minimum_rate'   =>  'required',

            'facebook'      => 'nullable',

            'facebook_followers' => 'nullable',

            'twitter' => 'nullable',

            'twitter_followers' => 'nullable',

            'instagram' => 'nullable',

            'instagram_followers' => 'nullable',

            'snapchat' => 'nullable',

            'snapchat_followers' => 'nullable',

            'linkedin' => 'nullable',

            'linkedin_followers' => 'nullable',

            'youtube'       => 'nullable',

            'youtube_followers' => 'nullable',

            'categories_id'      => 'required',

            'countries_id'    => 'required',

            'areas_id'      => 'required'





        ]);

        if ($this->isPhoneExists( $request->phone )) {
           return $this->setStatusCode(422)->respondWithError(trans('api_msgs.phone_exists'));
        }

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages());
         return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }




            $user = new User();


            $user->phone        =  $request->phone;

            $user->email        =  $request->email;

            $user->password     =  bcrypt($request->password);

            $user->image       = $request->image;

            $user->name         =  $request->name;

            $user->gender      =    $request->gender;

            $user->nationality_id       = $request->nationality_id;


            $user->notes             = $request->notes;

            $user->account_manger      = $request->account_manger;



            $user->minimum_rate      =$request->minimum_rate;

            $user->facebook          = $request->facebook;

            $user->facebook_followers  = $request->facebook_followers;

            $user->twitter            = $request->twitter;

            $user->twitter_followers   = $request->twitter_followers;

            $user->instagram           = $request->instagram;

            $user->instagram_followers  =$request->instagram_followers;

            $user->snapchat            = $request->snapchat;

            $user->snapchat_followers   = $request->snapchat_followers;

            $user->linkedin             = $request->linkedin;

            $user->linkedin_followers   = $request->linkedin_followers;

            $user->youtube             = $request->youtube;

            $user->youtube_followers   = $request->youtube_followers;

            $user->account_type = 1;

           // $user->categories_id  =$request->categories_id;









            $user->is_active    =  '1';
            $user->save();

           $categories_id  =$request->categories_id;

            foreach ($categories_id  as $id) {
                UserCategory::create([

                'user_id'       => $user->id,

                'categories_id' => $id,


                      ]);
            }
            $countries_id  =$request->countries_id;

            foreach ($countries_id  as $id) {
                UserCountry::create([

                'user_id'       => $user->id,

                'country_id' => $id,


                      ]);
            }

            $areas_id  =$request->areas_id;

            foreach ($areas_id  as $id) {
                UserArea::create([

                'user_id'       => $user->id,

                'area_id' => $id,


                      ]);
            }







           // $this->createVerificationCode( arTOen($request->phone) );

            $token = JWTAuth::fromUser($user);

            return Response::json( compact('token'));




    }


    public function isEmailExists( Request $request )
    {
        $validator = Validator::make( $request->all(), [
            'email'         => 'required|email|unique:users'
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.email_exists'));
        }
        return $this->respondWithSuccess('success');

    }



    public function checkPhone( Request $request )
    {
        $validator = Validator::make( $request->all(), [
            'phone'         => 'required|unique:users'
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.phone_exists'));
        }
        return $this->respondWithSuccess('success');

    }


     public function checkData( Request $request )
    {
        $validator = Validator::make( $request->all(), [
            'phone'         => 'required|unique:users',
            'email'         => 'required|unique:users'
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.data_exists'));
        }
        return $this->respondWithSuccess('success');

    }



   /* public function login( Request $request )
    {
    	$validator = Validator::make( $request->all(), [
            'phone'         => 'required',
            'email'			=> 'required',
            'password'		=> 'required',
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters failed validation');
        }
        $credentails =  $request->only('phone','email' ,'password');

        if ( !$this->isActiveAccount( $credentails ) ) {

            return $this->respondUnauthorized( trans('api_msgs.check_credentials') );

        }else{

			return $this->generateToken( $request->only('phone','email' ,'password') );

        }

    }*/


    public function login(Request $request){
      if(strpos($request->server("REQUEST_URI"), '/user/login'))
      {
          $type = 0;
      }
      elseif(strpos($request->server("REQUEST_URI"), '/influncer/login'))
      {
          $type = 1;
      }
      else {
        return $this->setStatusCode(422)->respondWithError('user type not exising');
      }
        $validator = Validator::make($request -> all(),[
         'email' => 'required',
         'password'=> 'required',
        ]);
        /*if ($validator -> fails()) {
            # code...
            return response()->json($validator->errors());

        }*/

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters failed validation');
        }


        $credentials = $request->only('email','password');
         if ( !$this->isActiveAccount( $credentials ) ) {

            return $this->respondUnauthorized( trans('api_msgs.check_credentials') );

        }else{

            return $this->generateToken( $request->only('email' ,'password') );

        }

    }









    public function isActiveAccount( array $credentails ) :bool
    {
         if (! Auth::attempt(['email' => $credentails['email'] , 'password' => $credentails['password'] ,'is_active'=> '1' ])) {
            // not active user
            return false;

        }else{

            return true;
        }
    }


    public function isPhoneVerified( $phone )
    {
    	$isVerified = VerifyPhoneCode::where([ [ 'phone', $phone ],[ 'verified', '1'] ])->first();
    	 return $isVerified ? true :false;
    }

    public function uploadProfileImage( $image )
    {
    		$imagePath = "";
            $image_name = time().time().'_profile.'.$image->getClientOriginalExtension();
            $imageDir   = base_path() .'/public/assets/images/profile';
            $upload_img = $image->move($imageDir,$image_name);
            $imagePath  = '/public/assets/images/profile/'.$image_name;

            return $imagePath;
    }



    public function generateToken( $credentails )
    {

    	try {
            if ( !$token = JWTAuth::attempt($credentails) ) {

                   return $this->respondUnauthorized( trans('api_msgs.check_credentials') );
            }

        } catch (JWTException $e) {

            return $this->setStatusCode(500)->respondWithError('can not create token');
        }


        return $this->respond(['token' => $token ]) ;
    }





    public function refreshToken(Request $request)
    {

        $current_token  = JWTAuth::getToken();


        if ( !$current_token ) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        try {

            $token = JWTAuth::refresh($current_token);

        } catch (JWTException $e) {

            return $this->respondForbidden('token_invalid');

        }

        $user = JWTAuth::toUser($token);

        if ($user->is_active == '0') {

            return $this->respondForbidden('token_invalid');
        }

        return $this->respond(['token' =>$token]);
    }



    public function logout(Request $request)
    {
        $user = $this->getAuthenticatedUser();

        //$validator = Validator::make( $request->all(), [
           // 'player_id'     => 'required',
        //]);

       // if ($validator->fails()) {
         //   return $this->setStatusCode(422)->respondWithError('parameters failed validation');
       // }


        $current_token  = JWTAuth::getToken();

        if ( !$current_token ) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        //UserPlayerId::where([['user_id', $user->id ],['player_id' , $request->player_id ]])->delete();
        JWTAuth::setToken( $current_token )->invalidate();
        return $this->respondWithSuccess( trans('api_msgs.loggedout') );

    }


    /*  public function logout(Request $request)
    {
        // Get JWT Token from the request header key "Authorization"
       // $token = $request->header('Authorization');
        // Invalidate the token
        try {
            JWTAuth::invalidate($token);
            return response()->json([
                'status' => 'success',
                'message'=> "User successfully logged out."
            ]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
              'status' => 'error',
              'message' => 'Failed to logout, please try again.'
            ], 500);
        }
    }*/































}
