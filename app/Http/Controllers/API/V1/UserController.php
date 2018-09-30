<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as Controller;
//use App\Notification;
use App\Transformers\ProfileTransformer;
use App\User;
use App\UserCategory;
use App\UserCountry;
use App\UserArea;
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

    public function isPhoneExists( $phone )
    {
        return User::where('phone',$phone)->first() ? true : false;
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

            'countries_id' => 'required',

            'type'      => 'required',

            'facebook'      => 'nullable',

            'twitter'      => 'nullable',

            'instgrame'      => 'nullable',

            'snapchat'      => 'nullable',

            'linkedin'      => 'nullable',

            'youtube'      => 'nullable'

            
            
        ]);

        
        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages());
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

        $user->countries_id  = $request->countries_id;
 
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
            'email'	   => 'required|string|max:30|min:2',

             'password'      => 'required|string|max:25|min:8',
            

            'image'         => 'required',

            'name'          => 'required',

            'gender'        => 'required',

            'nationality_id' => 'required',

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

            'areas_id'      => 'required'



        ]);

        
        if ($validator->fails()) {
             return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }

       

        $user = User::find( $user->id );

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
            
            $user->password     =  bcrypt($request->password);  
            $user->image        = $request->image;

            $user->name         =  $request->name;

            $user->gender       =    $request->gender;

            $user->nationality_id    = $request->nationality_id;


            $user->notes             = $request->notes;

            $user->account_manger      = $request->account_manger;

            

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

            $user->is_active    =  '1'; 
            $user->save();
           

        $categories_id  =$request->categories_id;    

            foreach ($categories_id  as $id) {
                UserCategory::firstOrCreate([

                'user_id'       => $user->id,

                'categories_id' => $id,
            

                      ]);
            }



        return $this->respondWithSuccess(trans('api_msgs.profile_updated'));


    }



    public function isEmailExists( $email , $user_id )
    {
        return User::where([['id','<>',$user_id] ,['email' ,$email]])->first() ?  true : false ;
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
