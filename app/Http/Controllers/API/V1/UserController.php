<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as Controller;
//use App\Notification;
use App\Transformers\ProfileTransformer;
use App\User;
//use App\UserPlayerId;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

	protected $profileTransformer;

    function __construct(Request $request, ProfileTransformer $profileTransformer ){
        App::setlocale($request->lang);
    	$this->middleware('jwt.auth');
    	$this->profileTransformer = $profileTransformer;
    }


    public function profile( Request $request )
    {
    	$user =  $this->getAuthenticatedUser();
    	return $this->respond(['data' => $this->profileTransformer->transform($user) ]);
    }



    public function influncerProfile( Request $request )
    {
        $influncer =  $this->getAuthenticatedUser();
        return $this->respond(['data' => $this->profileTransformer->transform($influncer) ]);
    }



    public function updateProfile( Request $request )
    {
        $user =  $this->getAuthenticatedUser();

        $validator = Validator::make( $request->all(), [
            'name'         => 'required|string|max:50|min:2',

            'email'      => 'required',

            'phone'      => 'required',

            'image'      => 'required|string',

            'notes'     => 'required',

            'country_id' => 'required',

            'type'      => 'required',

            'facebook'      => 'nullable',

            'twitter'      => 'nullable',

            'instgrame'      => 'nullable',

            'snapchat'      => 'nullable',

            'linkedin'      => 'nullable',

            'youtube'      => 'nullable'

            
            
        ]);

        
        if ($validator->fails()) {
            // return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }

       

        $user = User::find( $user->id );

        $user->name      =  $request->name;
        
        if ( $request->email )   {

            if ($this->isEmailExists($request->email, $user->id)) {
                return $this->setStatusCode(422)->respondWithError(trans('api_msgs.email_exists'));
            }
            $user->email   = $request->email;
         }

         if ( $request->phone )   {

            if ($this->isPhoneExists($request->phone, $user->id)) {
                return $this->setStatusCode(422)->respondWithError(trans('api_msgs.phone_exists'));
            }
            $user->phone   = $request->phone;
         }

        $user->image   =  $request->image;

        $user->notes       = $request->notes;

        $user->type        = $request->type;

        $user->country_id  = $request->country_id;
 
        $user->facebook    = $request->facebook;

        $user->twitter     = $request->twitter;

        $user->instgrame   = $request->instgrame;

        $user->snapchat    = $request->snapchat;

        $user->snapchat    = $request->snapchat;

        $user->linkedin    = $request->linkedin;

        $user->youtube    = $request->youtube;


        $user->save();

        return $this->respondWithSuccess(trans('api_msgs.profile_updated'));


    }

    public function updateInfluncerProfile(Request $request )
    {
    	$user =  $this->getAuthenticatedUser();

    	$validator = Validator::make( $request->all(), [
            'name'     => 'required|string|max:50|min:2',
            'email'	   => 'nullable|string|max:30|min:2',
            'image'			=> 'nullable',
            'nationality'   => 'nullable',
            'notes'         => 'required',
            'account_manger' => 'required',

            'type' => 'required',

            'facebook' =>'nullable',

            'facebook_follwers' => 'nullable',

            'twitter' => 'nullable',

            'twitter_follwers' => 'nullable',

            'instgrame' => 'nullable',

            'instgrame_follwers' => 'nullable',

            'snapchat' =>'nullable',

            'snapchat_follwers'  => 'nullable',

            'linkedin' => 'nullable',

            'linkedin_follwers' => 'nullable',

            'youtube'  => 'nullable',

            'youtube_follwers' => 'nullable'



        ]);

        
        if ($validator->fails()) {
            // return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }

       

        $user = User::find( $user->id );

        $user->name 		=  $request->name;
        if ( $request->full_name )   {
            $user->full_name 	= $request->full_name;
        }
        if ( $request->email )   {

            if ($this->isEmailExists($request->email, $user->id)) {
                return $this->setStatusCode(422)->respondWithError(trans('api_msgs.email_exists'));
            }
            $user->user_email 	= $request->email;
         }
		$user->user_image 	=  $request->image;
        $user->save();

        return $this->respondWithSuccess(trans('api_msgs.profile_updated'));


    }


    public function isEmailExists( $email , $user_id )
    {
        return User::where([['id','<>',$user_id] ,['user_email' ,$email]])->first() ?  true : false ;
    }


    public function updatePassword( Request $request )
    {
        $user =  $this->getAuthenticatedUser();

        $validator = Validator::make( $request->all(), [
            'old_password'  => 'required',
            'new_password'  => 'required|string|max:25|min:8'
        ]);

        
        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('paramters failed validation');
        }
        if ($this->isCorrectOldPassword( $user->id , $request->old_password )  ) {

            $user = User::find( $user->id );
            $user->password     =  bcrypt($request->new_password);
            $user->save();
            return $this->respondWithSuccess(trans('api_msgs.password_updated'));


        }else{

            return $this->respondWithError(trans('api_msgs.wrong_password'));

        }

    }

    public function isCorrectOldPassword( $user_id , $password )
    {
        $user =  User::find($user_id);
        $isValidPassword = Hash::check($password, $user->password);
        return $isValidPassword ? true : false;
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


    /**
     * update player id for onesignal notification
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updatePlayerId( Request $request )
    {
        $user =  $this->getAuthenticatedUser();

        $validator = Validator::make( $request->all(), [
            'player_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('paramters failed validation');
        }

        UserPlayerId::firstOrCreate(['user_id' =>  $user->id , 'player_id' => $request->player_id ]);

        return $this->respondWithSuccess('sucess');

    }



    public function getNotifications( Request $request )
    {
        $user =  $this->getAuthenticatedUser();
        
        $notifications =  Notification::where('user_id' , $user->id)->latest()->get();

        return $this->respond(['data' => $notifications ]);
    }


    






}
