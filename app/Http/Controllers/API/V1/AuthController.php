<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as Controller;
use App\User;
use App\Country;
use App\UserCategory;
use App\UserCountry;
use App\UserArea;
use App\UserPlayerId;
use App\VerifyPhoneCode;
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




    public function formatPhone( $phone,$country_id )
    {

    //$country_code = Country::where('id',$country_id)->pluck('code');
    $country_code = Country::where('id',$country_id)->first();
        
    if($country_code) $country_code = $country_code->code;
    else $country_code = "966";

	$is_valid_phone = preg_match('/^(009665|9665|\+9665|05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/', $phone);
        if ($is_valid_phone) {
            if (strncmp($phone, $country_code, 3) === 0) {
                return $phone;
            }else{
                //return substr_replace($phone , $country_code, 0 , 1 );
                return $country_code.$phone;
            }
        }

        return false;
    }


    public function verifyMobileCode( Request $request )
    {
        $validator = Validator::make( $request->all(), [
            'code'                  => 'required|max:4|min:4',
            'phone'                  => 'required|max:14|min:9',
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        $code   = VerifyPhoneCode::where([ [ 'code', $request->code ],['phone',$request->phone],[ 'verified', '0'] ])->first();

        if ( !$code ) {

            return $this->setStatusCode(404)->respondWithError(trans('api_msgs.invalid_code'));
        }

        $current_time   = Carbon::now();
        $current    = strtotime($current_time->addHours(1)->toDateTimeString());
        $expired_at = strtotime($code->expired_at);
        if ( $expired_at < $current or $expired_at == $current )  {

            return $this->setStatusCode(404)->respondWithError(trans('api_msgs.code_expire'));

        }else{

             

            if($request->header('Authorization') && $request->header('Authorization') != '' && $request->header('Authorization') != null && $request->header('Authorization') != "null"){
                // check for update phone
                
                VerifyPhoneCode::where([ [ 'code', $request->code ],['phone',$request->phone],[ 'verified', '0'] ])->update(['verified' => '1']);

                $user_auth =  $this->getAuthenticatedUser();
                User::where([[ 'id', $user_auth->id] ])->update(['phone' => $code->phone]);
                return $this->respondWithSuccess(trans('api_msgs.success'));
            }
            //VerifyPhoneCode::where('id', $user->id)->where('id', $user->id)
            //return $this->respondWithSuccess('sucess');

            $user = User::where('phone', $code->phone)->first();
            if($user)
            {

                VerifyPhoneCode::where([ [ 'code', $request->code ],['phone',$request->phone],[ 'verified', '0'] ])->update(['verified' => '1']);

                if($user->account_type == 1) //influencer
                {
                    if($user->is_active == 1)
                    {
                        $token = JWTAuth::fromUser($user);
                        return Response::json( compact('token'));
                    }
                    return $this->respondWithSuccess(trans('api_msgs.success'));
                }
                // user
                $token = JWTAuth::fromUser($user);

                return Response::json( compact('token'));
            }
            else
            {
                return $this->setStatusCode(422)->respondWithError('parameters faild validation');
            }
            
        }
    }


    public function isUserPhoneExists( $phone , $user_id )
    {
        return DB::table('users')->where([['id','<>',$user_id] ,['phone' ,$phone]])->first() ?  true : false ;

    }


    public function sendVerifyCode( Request $request )
    {
      // atef comment //should also validate if data sent are email.
        $validator = Validator::make( $request->all(), [
            'country_id'             => 'required',
            'phone'                  => 'required',
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.enter_valid_phone'));
        }

        if($request->header('Authorization') && $request->header('Authorization') != '' && $request->header('Authorization') != null && $request->header('Authorization') != "null"){
            $user_auth =  $this->getAuthenticatedUser();

            if ($this->isUserPhoneExists( $request->phone ,$user_auth->id)) {
                return $this->setStatusCode(422)->respondWithError(trans('api_msgs.phone_exists'));
            }

            if($request->phone == $user_auth->phone)
            {
                return $this->setStatusCode(405)->respondWithError(trans('api_msgs.nothing_to_update')); 
            }
        }


        //create verify phone code
        $this->createVerificationCode( $request->phone,$request->country_id );

        return $this->respondWithSuccess(trans('api_msgs.sms_code_text'));
    }

	public function createVerificationCode( $phone,$country_id )
    {
        $verify_code    = rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9);
        $current_time   = Carbon::now();
        $created_at     = $current_time->toDateTimeString();
        $expired_at     = $current_time->addHours(24)->toDateTimeString();
        VerifyPhoneCode::where('phone', $phone)->delete();
        DB::table('verify_phone_codes')->insert([
		         'phone'         => $phone ,
                   'code'          => $verify_code ,
		         'created_at'    => $created_at,
		        'expired_at'    => $expired_at
	                                            ]);
        //send message to mobile
        //@sendSMS($phone , __('api_msgs.sms_code_text').$verify_code );
        @sendSMS($this->formatPhone($phone,$country_id) , __('api_msgs.sms_code_text').$verify_code );
    }


    public function isPhoneExists( $phone )
    {
        return User::where('phone',$phone)->first() ? true : false;
    }

    public function isMailExists( $email )
    {
        return User::where('email',$email)->first() ? true : false;
    }

    /*public function isEmailExists( $email )
    {
        return User::where('email',$email)->first() ? true : false;
    }*/

    public function influncerHasOffer($influncer_id,$campaign_id)
    {
         return User::where([
            ['influncer_id',$influncer_id],
            ['campaign_id',$campaign_id]
            ])->first() ? true : false;
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
        // dd(App::getLocale());
    	$validator = Validator::make( $request->all(), [

            'email'         => 'required',

            'phone'         => 'required|max:14|min:9|regex:/^[5][0-9]{4,}/',

            'country_id'    => 'required',

            'password'      => 'required|string|max:16|min:8',

            'image'         => 'nullable',

            //'name'          => 'required|string|max:25|min:3',
            'name'          => 'required|string|min:3',

            'notes'         => 'required',

            'type'          => 'required',

            'facebook'      => 'nullable',



            'twitter' => 'nullable',



            'instgrame' => 'nullable',



            'snapchat' => 'nullable',



            'linkedin' => 'nullable',



            'youtube'       => 'nullable'



        ]);

        if ($this->isPhoneExists( $request->phone )) {
           return $this->setStatusCode(409)->respondWithError(trans('api_msgs.phone_exists'));
        }

         if ($this->isMailExists( $request->email )) {
           return $this->setStatusCode(408)->respondWithError(trans('api_msgs.email_exists'));
        }



        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages()->first());
            //return $this->setStatusCode(422)->respondWithError($validator->messages());
            //return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }




		  $user = new User();


           $user->phone         =  $request->phone;

            $user->email        =  $request->email;

            $user->password     =  bcrypt($request->password);

             if(!$request->image){
                $user->image  ='/public/assets/images/profile/main.png';

            }else{
                $user->image        = $request->image;

            }


            $user->name         =  $request->name;

            $user->notes        = $request->notes;

            $user->type         = (string) $request->type;

            $user->facebook     = $request->facebook;


            $user->twitter      = $request->twitter;

            $user->instgrame    = $request->instgrame;


            $user->snapchat     = $request->snapchat;


            $user->linkedin     = $request->linkedin;


            $user->youtube      = $request->youtube;

            $user->countries_id = $request->country_id;




            $user->is_active        =  '1';
            $user->account_type     =  '0';
            $user->save();


           $this->createVerificationCode( arTOen($request->phone),$request->country_id );

            //$token = JWTAuth::fromUser($user);

            //return Response::json( compact('token'));

           return $this->respondWithSuccess(trans('api_msgs.success'));


    }

    public function registerInfluncer( Request $request )
    {


        $validator = Validator::make( $request->all(), [

            'email'         => 'required|unique:users,email',

            'phone'         => 'required|max:14|min:9|regex:/^[5][0-9]{4,}/',

            'password'      => 'required|string|max:16|min:8',

            'image'         => 'nullable',

            //'name'          => 'required',
            'name'          => 'required|string|min:3',

            'gender'        => 'required',

            'country_id'    => 'required',

            'nationality_id'   => 'required',

            'notes'          => 'required',

            'account_manger' => 'required',



            'minimumRate'   =>  'required',

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

            'youtube_follwers' => 'nullable',

            'categories_id'      => 'required',

            'countries_id'    => 'required',

            'areas_id'      => 'nullable'





        ]);

        if ($this->isPhoneExists( $request->phone )) {
           return $this->setStatusCode(409)->respondWithError(trans('api_msgs.phone_exists'));
        }

         if ($this->isMailExists( $request->email )) {
           return $this->setStatusCode(408)->respondWithError(trans('api_msgs.email_exists'));
        }

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages()->first());
            //return $this->setStatusCode(422)->respondWithError($validator->messages());
            //return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }




            $user = new User();


            $user->phone        =  $request->phone;

            $user->email        =  $request->email;

            $user->password     =  bcrypt($request->password);

             if(!$request->image){
                $user->image  ='/public/assets/images/profile/main.png';

            }else{
                $user->image        = $request->image;

            }




            $user->name         =  $request->name;

            $user->gender      =   $request->gender;

            $user->countries_id = $request->country_id;

            $user->nationality_id   = $request->nationality_id;


            $user->notes             = $request->notes;

            $user->account_manger      = $request->account_manger;



            $user->minimumRate       = $request->minimumRate;

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

            $user->account_type = '1';

           // $user->categories_id  =$request->categories_id;






            $user->is_active    =  '0';

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
            if($areas_id !== null){

            foreach ($areas_id  as $id) {
                UserArea::create([

                'user_id'       => $user->id,

                'area_id' => $id,


                      ]);
            }
        }


            $this->createVerificationCode( arTOen($request->phone),$request->country_id );

            return $this->respondWithSuccess(trans('api_msgs.success'));
            //$token = JWTAuth::fromUser($user);

            //return Response::json( compact('token'));




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

        if ($this->isMailExists( $request->email )) {
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.email_exists'));
        }
        
        if ($this->isPhoneExists( $request->phone )) {
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.phone_exists'));
        }
 
       
        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.data_exists'));
        }
        return $this->respondWithSuccess('success');

    }


    /*public function login(Request $request){
        $validator = Validator::make($request -> all(),[
         'email' => 'required',
         'password'=> 'required'
        ]);

        if ($validator -> fails()) {
            # code...
            return response()->json($validator->errors());

        }


        $credentials = $request->only('email','password');
        try{
            if (! $token = JWTAuth::attempt( $credentials) ) {
                # code...
                return response()->json( ['error'=> 'invalid email and password'],401);
            }
        }catch(JWTExceptiocredentialsn $e){

          return response()->json( ['error'=> 'could not create token'],500);
        }


        return response()->json( compact('token'));

    }*/



    /*public function login( Request $request )
    {
    	$validator = Validator::make( $request->all(), [

            'email'			=> 'required',
            'password'		=> 'required'
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters failed validation');
        }
        $credentails =  $request->only('email' ,'password');

        if ( !$this->isActiveAccount( $credentails ) ) {

            return $this->respondUnauthorized( trans('api_msgs.check_credentials') );

        }else{

			return $this->generateToken( $request->only('email' ,'password') );

        }

    }*/

    public function checkLogin($email,$password,$account_type)
    {
        return User::where([
            ['email',$email],
            ['password',$password],
            ['account_type',$account_type]
            ])->first() ? true : false;
    }


    public function login(Request $request){

    //   if($request->input('email'))
    //   {
    //     $check_input = 'email';
    //   }
    //   else
    //   {
    //     $check_input = 'phone';
    //   }
    
      if(strpos($request->server("REQUEST_URI"), '/user/login'))
      {
          $account_type = '0';


      }
      elseif(strpos($request->server("REQUEST_URI"), '/influncer/login'))
      {
          $account_type = '1';
      }
      else {
        return $this->setStatusCode(422)->respondWithError('user type not exising');
      }
        $validator = Validator::make($request->all(),[
         'country_id'   => 'required',
         'phone'   => 'required',
         'password'=> 'required'
        ]);
        
         if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters failed validation');
        }

        
       
        // $login_type = filter_var($request->input($check_input), FILTER_VALIDATE_EMAIL ) 
        // ? 'email' 
        // : 'phone';
 
        // $request->merge([$login_type => $request->input($check_input)]);
        // if($login_type == 'email') $field = 'email';
        // else $field = 'phone';

        //$credentials = $request->only($login_type,'password');
        $credentials = $request->only('country_id','phone','password');

        //dd($credentials);

        
         if ( !$this->isActiveAccount( $credentials,$account_type ) ) {

            
            // block user after number of attempts
            User::where('phone',$request->phone)->increment('login_attempts');

            $userdata = User::where('phone',$request->phone)->first();

            if($userdata->login_attempts >= 5 && $userdata->block == "0")
            {
                $userdata->block = '1';
                $userdata->block_time = Carbon::now()->addHours(1);
                $userdata->save();
            }
            
            return $this->setStatusCode(401)->respondWithError(trans('api_msgs.check_credentials'));     

        }
        else
        {
            if(!$this->isBlocked($request->input('phone')))
            {
                return $this->setStatusCode(406)->respondWithError(trans('api_msgs.blocked_user'));
            }

            if(!$this->isPhoneVerified($request->input('phone')))
        {
            //return $this->respondUnauthorized( trans('api_msgs.activate_msg') );
            return $this->setStatusCode(403)->respondWithError(trans('api_msgs.activate_msg'));
        }    

            if(!$this->CheckActiveAccount( $credentials,$account_type ))
        {
            return $this->setStatusCode(405)->respondWithError(trans('api_msgs.check_credentials2'));
        }

            
            return $this->generateToken( $request->only('phone','password') );

        }


    }




    public function isBlocked($phone)
    {
        $isBlocked = User::where([ [ 'phone1', $phone ],[ 'block', '1'] , ['block_time','>=', Carbon::now()]])->first();
    	return $isBlocked ? true :false;
    }

    public function CheckActiveAccount( array $credentails, $type ) :bool
    {
         if (! Auth::attempt(['countries_id' => $credentails['country_id'] , 'phone' => $credentails['phone'] , 'password' => $credentails['password'] ,'is_active'=> '1' ,'account_type' => $type])) {
            // not active user
            return false;

        }else{

            return true;
        }
    }




    public function isActiveAccount( array $credentails, $type ) :bool
    {
         if (! Auth::attempt(['countries_id' => $credentails['country_id'] , 'phone' => $credentails['phone'] , 'password' => $credentails['password'] ,'account_type' => $type])) {
            // not active user
            return false;

        }else{

            return true;
        }
    }


    public function isPhoneVerified( $phone )
    {
        $isVerified = VerifyPhoneCode::where([ [ 'phone', $phone ],[ 'verified', '1'] ])->orderBy('id', 'DESC')->first();
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

        $validator = Validator::make( $request->all(), [
            'player_id'     => 'required',
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters failed validation');
        }

        $current_token  = JWTAuth::getToken();

        if ( !$current_token ) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        UserPlayerId::where([['user_id', $user->id ],['player_id' , $request->player_id ]])->delete();
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
