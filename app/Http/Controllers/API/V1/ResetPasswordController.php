<?php

namespace App\Http\Controllers\API\V1;
use App\Http\Controllers\API\V1\BaseController as Controller;
use App\User;
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









    public function sendCode( Request $request )
    {
      // atef comment //should also validate if data sent are email.
        $validator = Validator::make( $request->all(), [
            'phone'                  => 'required|max:14|min:9|exists:users',
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.enter_valid_phone'));
        }

        //create reset password code
        $this->createToken( $request->phone );

        return $this->respondCreated(trans('api_msgs.code_sent'));
    }

    



    public function createToken( $phone )
    {
        $token    = rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9);
        $current_time   = Carbon::now();
        $created_at     = $current_time->toDateTimeString();
        $expired_at     = $current_time->addHours(1)->toDateTimeString();
        DB::table('phone_forget_password')->insert([
                   'phone'         => $phone ,
                   'token'         => $token ,
                   'created_at'    => $created_at,
                   'expired_at'    => $expired_at
                                                ]);
        //send message to mobile
        @sendSMS($this->formatPhone($mail) , __('api_msgs.reset_pass_code').$token );

    }

    public function formatPhone( $phone )
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

            return $this->setStatusCode(404)->respondWithError(trans('api_msgs.invalid_code'));
        }

        $current    = strtotime(Carbon::now()->toDateTimeString());
        $expired_at = strtotime($code->expired_at);

        if ( $expired_at < $current or $expired_at == $current )  {

            return $this->setStatusCode(404)->respondWithError(trans('api_msgs.invalid_code'));

        }else{

            return $this->respondWithSuccess('sucess');
        }
    }






    public function resetPassword( Request $request )
    {

        $validator = Validator::make( $request->all(), [
            'code'                  => 'required|max:4|min:4',
            'password'              => 'required|string|max:25|min:8'
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        $code   = ResetPassword::where([ [ 'token', $request->code ],[ 'used', '0'] ])->first();

        if ( !$code ) {

            return $this->setStatusCode(404)->respondWithError(trans('api_msgs.invalid_code'));
        }

        $current    = strtotime(Carbon::now()->toDateTimeString());
        $expired_at = strtotime($code->expired_at);

        if ( $expired_at < $current or $expired_at == $current )  {

            return $this->setStatusCode(404)->respondWithError(trans('api_msgs.invalid_code'));

        }else{
            ResetPassword::where([ [ 'token', $request->code ],[ 'used', '0'] ])->update(['used' => '1']);

            //update the password
           $this->updatePassword( $code->phone , $request->password );

            return $this->respondWithSuccess(trans('api_msgs.reset_sccuess'));
        }


    }


    public function updatePassword(  $phone , $password )
    {
        User::where('phone' , $phone )->update(['password' => bcrypt($password)]);
    }



}
