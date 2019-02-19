<?php

namespace App\Http\Controllers\API\V1;
use App\Http\Controllers\API\V1\BaseController as Controller;
use App\User;
use App\Country;
use App\VerifyPhoneCode;
use App\ResetPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ResetPasswordController extends Controller
{

    function __construct( Request $request ){
        App::setlocale($request->lang);
    }


     public function sendMail( Request $request )
    {
      // atef comment //should also validate if data sent are email.
        $validator = Validator::make( $request->all(), [
            'email'                  => 'required|exists:users',
        ]);

         if ($validator->fails()) {
             return $this->setStatusCode(422)->respondWithError(trans('api_msgs.enter_valid_email'));
        }

        //create reset password code
        Password::sendResetLink(['email' => $request->email]);
      
        //Password::sendResetLink(['email' => $request->email]);

        return $this->respondCreated(trans('api_msgs.Mail_sent'));
    }





    public function createMailToken( $email )
    {
        $token    = rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9);
        $current_time   = Carbon::now();
        $created_at     = $current_time->toDateTimeString();
        //$expired_at     = $current_time->addHours(1)->toDateTimeString();
      
        //send Mail to mobile

    }



    public function LastSmS($phone,$type=1,$account_type='0') // type = 1 tabel forget | type = 2 table verify
    {
        if($type == 1)
        {
            $lastsms = ResetPassword::where('phone', $phone)->where('account_type',$account_type)->orderBy('created_at', 'DESC')->first();
        }
        else 
        {
            $lastsms = VerifyPhoneCode::where('phone', $phone)->where('account_type',$account_type)->orderBy('id', 'DESC')->first();
        }
         
        
        if($lastsms)
        {
            if($lastsms->created_at->diffInSeconds(Carbon::now()) < 30)
            {
                return true;
            }
            else 
            {
                return false;    # code...
            }
        }
        return false;
    }



    public function isPhoneExists( $phone , $account_type )
    {
        return User::where('phone',$phone)->where('account_type',$account_type)->first() ? true : false;
    }

    public function sendCode( Request $request )
    {
      // atef comment //should also validate if data sent are email.
        $validator = Validator::make( $request->all(), [
            'country_id'    => 'required',
            'phone'                  => 'required|max:14|min:9|exists:users',
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.enter_valid_phone'));
        }

        $account_type = '0';
        if($request->header('account-type'))
        {
            $account_type = $request->header('account-type');
        }

        if (!$this->isPhoneExists( $request->phone , $account_type )) {
           return $this->setStatusCode(409)->respondWithError(trans('api_msgs.phone_exists'));
        }

        $lastSmS = $this->LastSmS($request->phone,1,$account_type); // check if message send and not passed 30 second
        if(!$lastSmS)
        {
            //create reset password code
            $this->createToken( $request->phone,$request->country_id,$account_type );
        }
        return $this->respondCreated(trans('api_msgs.code_sent'));
    }

    



    public function createToken( $phone,$country_id,$account_type )
    {
        $token    = rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9);
        $current_time   = Carbon::now();
        $created_at     = $current_time->toDateTimeString();
        $expired_at     = $current_time->addHours(1)->toDateTimeString();
        DB::table('phone_forget_password')->insert([
                   'phone'         => $phone ,
                   'account_type'  => $account_type ,
                   'token'         => $token ,
                   'created_at'    => $created_at,
                   'expired_at'    => $expired_at
                                                ]);
        //send message to mobile
        @sendSMS($this->formatPhone($phone,$country_id) , __('api_msgs.reset_pass_code').$token );

    }

    public function formatPhone( $phone,$country_id )
    {
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



    public function verifyCode( Request $request )
    {
        $validator = Validator::make( $request->all(), [
            'code'                  => 'required|max:4|min:4'
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        $code   = ResetPassword::where([ [ 'token', $request->code ],[ 'used', '0'] ])->first();

        if ( !$code ) {

            return $this->setStatusCode(409)->respondWithError(trans('api_msgs.invalid_code'));
        }

        $current    = strtotime(Carbon::now()->toDateTimeString());
        $expired_at = strtotime($code->expired_at);

        if ( $expired_at < $current or $expired_at == $current )  {

            return $this->setStatusCode(409)->respondWithError(trans('api_msgs.invalid_code'));

        }else{
            //ResetPassword::where([ [ 'code', $request->code ],[ 'used', '0'] ])->update(['used' => '1']);
            return $this->respondWithSuccess('sucess');
        }
    }






    public function resetPassword( Request $request )
    {

        $validator = Validator::make( $request->all(), [
            'code'                  => 'required|max:4|min:4',
            'password'              => 'required|string|max:25|min:8'
        ]);


        $account_type = '0';
        if($request->header('account-type'))
        {
            $account_type = $request->header('account-type');
        }


        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        $code   = ResetPassword::where([ [ 'token', $request->code ],[ 'used', '0'] ])->first();

        if ( !$code ) {

            return $this->setStatusCode(409)->respondWithError(trans('api_msgs.invalid_code'));
        }

        $current    = strtotime(Carbon::now()->toDateTimeString());
        $expired_at = strtotime($code->expired_at);

        if ( $expired_at < $current or $expired_at == $current )  {

            return $this->setStatusCode(409)->respondWithError(trans('api_msgs.invalid_code'));

        }else{
            ResetPassword::where([ [ 'token', $request->code ],[ 'used', '0'] ])->update(['used' => '1']);

            //update the password
           $this->updatePassword( $code->phone , $request->password , $account_type );

            return $this->respondWithSuccess(trans('api_msgs.reset_sccuess'));
        }


    }


    public function updatePassword(  $phone , $password , $account_type='0')
    {
        User::where('phone' , $phone )->where('account_type',$account_type)->update(['password' => bcrypt($password)]);
    }



    //======================================================== send verify code ===========

    public function sendVerifyCode( Request $request )
    {
      // atef comment //should also validate if data sent are email.
        $validator = Validator::make( $request->all(), [
            'phone'                  => 'required|max:14|min:9|exists:users',
        ]);


        $account_type = '0';
        if($request->header('account-type'))
        {
            $account_type = $request->header('account-type');
        }


        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.enter_valid_phone'));
        }

        $lastSmS = $this->LastSmS($request->phone,2,$account_type); // check if message send and not passed 30 second
        if(!$lastSmS)
        {
            //create verify phone code
            $this->createVerifyToken( $request->phone ,$account_type );
        }
        return $this->respondCreated(trans('api_msgs.code_sent'));
    }

    public function createVerifyToken( $phone,$account_type )
    {
        $token    = rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9);
        $current_time   = Carbon::now();
        $created_at     = $current_time->toDateTimeString();
        $expired_at     = $current_time->addHours(1)->toDateTimeString();
        DB::table('verify_phone_codes')->insert([
                   'phone'         => $phone ,
                   'account_type'  => $account_type ,
                   'code'          => $token ,
                   'created_at'    => $created_at,
                   'expired_at'    => $expired_at
                                                ]);
        //send message to mobile
        @sendSMS($this->formatPhone($mail) , __('api_msgs.reset_pass_code').$token );

    }

    public function verifyMobileCode( Request $request )
    {
        $validator = Validator::make( $request->all(), [
            'code'                  => 'required|max:4|min:4'
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        $code   = VerifyPhoneCode::where([ [ 'code', $request->code ],[ 'verified', '0'] ])->first();

        if ( !$code ) {

            return $this->setStatusCode(409)->respondWithError(trans('api_msgs.invalid_code'));
        }

        $current_time   = Carbon::now();
        $current    = strtotime($current_time->addHours(1)->toDateTimeString());
        $expired_at = strtotime($code->expired_at);
        if ( $expired_at < $current or $expired_at == $current )  {

            return $this->setStatusCode(409)->respondWithError(trans('api_msgs.code_expire'));

        }else{

            VerifyPhoneCode::where([ [ 'code', $request->code ],[ 'verified', '0'] ])->update(['verified' => '1']);
            return $this->respondWithSuccess('sucess');
        }
    }



}
