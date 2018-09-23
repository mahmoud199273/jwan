<?php

namespace App\Http\Controllers\API\V1;
 
use App\Http\Controllers\API\V1\BaseController as Controller;
use App\User;
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

    	$validator = Validator::make( $request->all(), [

            'email'         => 'required',
        
            'phone'			=> 'required|max:14|min:9',
            
            'countries_id'    => 'required',

            'password'		=> 'required|string|max:25|min:8',

            'image'         => 'required',

            'name'          => 'required',

            'notes'         => 'required',

            'type'          => 'required',

            'facebook'      => 'nullable',

            'facebook_follwers' => 'nullable',

            'twitter' => 'nullable',

            'twitter_follwers' => 'nullable',

            'instgrame' => 'nullable',

            'instgrame_follwers' => 'nullable',

            'snapchat' => 'nullable',

            'snapchat_follwers' => 'nullable',

            'linkedin' => 'nullable',

            'linkedin_follwers' => 'nullable',

            'youtube'       => 'nullable',

            'youtube_follwers' => 'nullable'



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

            $user->facebook_follwers  = $request->facebook_follwers;

            $user->twitter            = $request->twitter;

            $user->twitter_follwers   = $request->twitter_follwers;

            $user->instgrame           = $request->instgrame;

            $user->instgrame_follwers  =$request->instgrame_follwers;

            $user->snapchat            = $request->snapchat;

            $user->snapchat_follwers   = $request->snapchat_follwers;

            $user->linkedin             = $request->linkedin;

            $user->linkedin_follwers   = $request->linkedin_follwers;

            $user->youtube             = $request->youtube;

            $user->youtube_follwers   = $request->youtube_follwers;

            $user->countries_id    = $request->countries_id;

            $user->is_active    =  '1'; 
			$user->save();

           // $this->createVerificationCode( arTOen($request->phone) );

            return $this->respondCreated(trans('api_msgs.code_sent'));
			


    	
    }

    public function registerInfluncer( Request $request )
    {

        $validator = Validator::make( $request->all(), [

            'email'         => 'required',
        
            'phone'         => 'required|max:14|min:9',
            
            'password'      => 'required|string|max:25|min:8',

            'image'         => 'required',

            'name'          => 'required',

            'gender'        => 'required',

            'nationality'   => 'required',

            'notes'          => 'required',

            'account_manger' => 'required',

            'type'          => 'required',

            'minimumRate'   =>  'required',

            'facebook'      => 'required',

            'facebook_follwers'   => 'required',

            'twitter'             => 'required',

            'twitter_follwers'    => 'required',
 
            'instgrame'           => 'required',

            'instgrame_follwers'  => 'required',

            'snapchat'            => 'required',

            'snapchat_follwers'   => 'required',

            'linkedin'            => 'required',

            'linkedin_follwers'   => 'required',

            'youtube'             => 'required',

            'youtube_follwers'    => 'required',

            'categories_id'      => 'required',

            'countries_id'    => 'required',

            'areas_id'      => 'required'

            



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

            $user->gender      =    $request->gender;

            $user->nationality       = $request->nationality;


            $user->notes             = $request->notes;

            $user->account_manger      = $request->account_manger;

            $user->type              = $request->type;

            $user->minimumRate      =$request->minimumRate;

            $user->facebook          = $request->facebook;

            $user->facebook_follwers  = $request->facebook_follwers;

            $user->twitter            = $request->twitter;

            $user->twitter_follwers   = $request->twitter_follwers;

            $user->instgrame           = $request->instgrame;

            $user->instgrame_follwers  =$request->instgrame_follwers;

            $user->snapchat            = $request->snapchat;

            $user->snapchat_follwers   = $request->snapchat_follwers;

            $user->linkedin             = $request->linkedin;

            $user->linkedin_follwers   = $request->linkedin_follwers;

            $user->youtube             = $request->youtube;

            $user->youtube_follwers   = $request->youtube_follwers;

            $user->categories_id  =$request->categories_id;

            $user->countries_id   =$request->countries_id;

            $user->areas_id   =$request->areas_id;

            $user->is_active    =  '1'; 
            $user->save();

           // $this->createVerificationCode( arTOen($request->phone) );

            return $this->respondCreated(trans('api_msgs.code_sent'));
            


        
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



    public function login( Request $request )
    {
    	$validator = Validator::make( $request->all(), [
            'phone'			=> 'required',
            'password'		=> 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters failed validation');
        }
        $credentails =  $request->only('phone' ,'password');

        if ( !$this->isActiveAccount( $credentails ) ) {

            return $this->respondUnauthorized( trans('api_msgs.check_credentials') );

        }else{

			return $this->generateToken( $request->only('phone' ,'password') );

        }
    		
    }


    public function isActiveAccount( array $credentails ) :bool
    {
         if (! Auth::attempt(['phone' => $credentails['phone'] , 'password' => $credentails['password'] ,'is_active'=> '1' ])) {
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


   /* public function logout(Request $request)
    {
        $user = $this->getAuthenticatedUser();

        /*$validator = Validator::make( $request->all(), [
            'player_id'     => 'required',
        ]);
        
        /*if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters failed validation');
        }
        

        $current_token  = JWTAuth::getToken();

        if ( !$current_token ) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        //UserPlayerId::where([['user_id', $user->id ],['player_id' , $request->player_id ]])->delete();
        JWTAuth::setToken( $current_token )->invalidate();
        return $this->respondWithSuccess( trans('api_msgs.loggedout') );

    }*/


    public function logout(Request $request) 
    {
        // Get JWT Token from the request header key "Authorization"
        $token = $request->header('Authorization');
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
    }





























}
