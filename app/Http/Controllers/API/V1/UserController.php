<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as Controller;
use App\Transformers\ProfileTransformer;
use App\Transformers\InfluncerTransformer;
use App\Transformers\CampaignsTransformer;
use App\Transformers\NotificationsTransformer;
use App\User;
use App\Campaign;
use App\Notification;
use App\UserPlayerId;
use App\UserCategory;
use App\UserCountry;
use App\UserArea;
use App\UserSocial;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DB;

class UserController extends Controller
{

    protected $profileTransformer;
    protected $influncerTransformer;
    protected $campaignsTransformer;
    protected $notificationsTransformer;

    function __construct(Request $request, ProfileTransformer $profileTransformer,InfluncerTransformer $influncerTransformer,CampaignsTransformer $campaignsTransformer,NotificationsTransformer $notificationsTransformer  ){
        App::setlocale($request->lang);
        $this->middleware('jwt.auth');
        $this->profileTransformer = $profileTransformer;
        $this->influncerTransformer = $influncerTransformer;
        $this->campaignsTransformer   = $campaignsTransformer;
        $this->notificationsTransformer   = $notificationsTransformer;
    }




    public function profile( Request $request )
    {

        $user =  $this->getAuthenticatedUser();
        if($user->account_type != 0)
                    {
                        return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
                    }

        return $this->respond(['data' => $this->profileTransformer->transform($user) ]);
    }



    public function influncerProfile( Request $request )
    {
        $influncer =  $this->getAuthenticatedUser();

        if($influncer->account_type != 1)
                    {
                        return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
                    }
        return $this->respond(['data' => $this->influncerTransformer->transform($influncer) ]);
    }



    public function updateProfile( Request $request )
    {


        $user =  $this->getAuthenticatedUser();
        if($user->account_type != 0)
                    {
                        return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
                    }

        $validator = Validator::make( $request->all(), [
            'name'         => 'required|string|max:50|min:2',

            'email'      => 'required',

            //'phone'      => 'required',

            'image'      => 'required|string',

            'notes'     => 'required',

            'type'      => 'required',

            'country_id' => 'required'



        ]);

        // if ($this->isPhoneExists( $request->phone ,$user->id)) {
        //    return $this->setStatusCode(422)->respondWithError(trans('api_msgs.phone_exists'));
        // }
        if ($this->isEmailExists( $request->email ,$user->id)) {
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.email_exists'));
         }


        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages()->first());
            //return $this->setStatusCode(422)->respondWithError($validator->messages());
            //return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }



        $user = User::find( $user->id );

        $user->name      =  $request->name;


        $user->email   = $request->email;


        // if ($user->phone  != $request->phone) {
        //     $user->phone   = $request->phone;
        // }


        $user->email        =  $request->email;
        if (substr( $request->image, 0, 4 ) !== "http") {
            $user->image        = $request->image;
        }



        $user->notes       = $request->notes;

        $user->countries_id = $request->country_id;
        $user->type = $request->type;


        $user->save();

        return $this->respondWithSuccess(trans('api_msgs.profile_updated'));


    }

    public function userChannels(Request $request)
    {
        $user =  $this->getAuthenticatedUser();

        $validator = Validator::make( $request->all(), [

            'facebook'      => 'nullable',


            'twitter' => 'nullable',



            'instgrame' => 'nullable',



            'snapchat' => 'nullable',



            'linkedin' => 'nullable',



            'youtube'     => 'nullable'







        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages()->first());
            //return $this->setStatusCode(422)->respondWithError($validator->messages());
            //return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }

            $user = User::find( $user->id );

            $user->facebook          = $request->facebook;



            $user->twitter            = $request->twitter;



            $user->instgrame           = $request->instgrame;



            $user->snapchat            = $request->snapchat;



            $user->linkedin             = $request->linkedin;



            $user->youtube             = $request->youtube;


        $user->save();
        return $this->respondWithSuccess(trans('api_msgs.profile_updated'));

    }

    public function updateInfluncerProfileSettings(Request $request)
    {
        $user =  $this->getAuthenticatedUser();

        if($user->account_type != 1)
                    {
                        return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
                    } 

            $validator = Validator::make( $request->all(), [
                'categories_id'      => 'nullable',
                'areas_id'      => 'nullable',
                'countries_id'    => 'nullable',
            ]);

            $categories_id  =$request->categories_id;
            if($categories_id !== null){
                UserCategory::where('user_id', $user->id)->forceDelete();
                foreach ($categories_id  as $id) {
                    UserCategory::create([

                    'user_id'       => $user->id,

                    'categories_id' => $id,


                        ]);
                }
            }
            $countries_id  =$request->countries_id;
            if($countries_id !== null){
                UserCountry::where('user_id', $user->id)->forceDelete();
                foreach ($countries_id  as $id) {
                    UserCountry::create([

                    'user_id'       => $user->id,

                    'country_id' => $id,


                        ]);
                }
            }

            $areas_id  =$request->areas_id;
            UserArea::where('user_id', $user->id)->forceDelete();

            if($areas_id !== null){
            foreach ($areas_id  as $id) {
                UserArea::create([

                'user_id'       => $user->id,

                'area_id' => $id,


                      ]);
            }
        }
        return $this->respondWithSuccess(trans('api_msgs.profile_updated'));
    }

    public function updateInfluncerProfile(Request $request )
    {
        $user =  $this->getAuthenticatedUser();

        if($user->account_type != 1)
                    {
                        return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
                    } 

        $validator = Validator::make( $request->all(), [
            'name'     => 'required|string|max:50|min:2',
            'email'    => 'required|string',

            //'phone'   => 'required|string',


            'image'         => 'required',

            'name'          => 'required',

            'gender'        => 'required',

            'country_id'   => 'required',


            'notes'          => 'required',

            'minimumRate'          => 'required',

            'nationality_id'   => 'required',

            'account_manger' => 'required',

            //'categories_id'      => 'nullable',

            //'areas_id'      => 'nullable'





        ]);




        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages()->first());
            //return $this->setStatusCode(422)->respondWithError($validator->messages());
            //return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
            //$user = User::find( $user->id );
        }
        //  if ($this->isPhoneExists( $request->phone ,$user->id)) {
        //    return $this->setStatusCode(422)->respondWithError(trans('api_msgs.phone_exists'));
        // }

        if ($this->isEmailExists( $request->email ,$user->id)) {
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.email_exists'));
        }


            // if ($user->phone != $request->phone) {
            //     # code...
            //     $user->phone        =  $request->phone;
            // }

            $user = User::find( $user->id );


            $user->email        =  $request->email;
            if (substr( $request->image, 0, 4 ) !== "http") {
                $user->image        = $request->image;
            }

            //if($request->nationality_id)
            //{
                $user->nationality_id         =  $request->nationality_id;
            //}

            $user->name         =  $request->name;

            $user->gender        =    $request->gender;

            $user->notes         = $request->notes;

            $user->minimumRate         = $request->minimumRate;

            $user->countries_id = $request->country_id;

            $user->account_manger  = $request->account_manger;

            $user->save();

        //$categories_id  =$request->categories_id;

        // if($categories_id !== null){
        //     UserCategory::where('user_id', $user->id)->forceDelete();
        //     foreach ($categories_id  as $id) {

        //         UserCategory::create([

        //         'user_id'       => $user->id,

        //         'categories_id' => $id,


        //               ]);
        //     }
        // }
            /* $countries_id  =$request->countries_id;

            foreach ($countries_id  as $id) {
                UserCountry::create([

                'user_id'       => $user->id,

                'country_id' => $id,


                      ]);
            } */

            // $areas_id  =$request->areas_id;

            // if($areas_id !== null){

            //     UserArea::where('user_id', $user->id)->forceDelete();
            //     foreach ($areas_id  as $id) {
            //         UserArea::create([

            //         'user_id'       => $user->id,

            //         'area_id' => $id,


            //             ]);
            //     }

            // }

        return $this->respondWithSuccess(trans('api_msgs.profile_updated'));


    }

    public function updateFollowers(Request $request)
    {
        $user =  $this->getAuthenticatedUser();

        if($user->account_type != 1)
                    {
                        return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
                    } 

        $validator = Validator::make( $request->all(), [

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

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages()->first());
            //return $this->setStatusCode(422)->respondWithError($validator->messages());
            //return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }

            $user = User::find( $user->id );
            if(!$user)
            {
                return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
            }

            UserSocial::where('user_id', $user->id)->delete();

            $user_social = new UserSocial;

            $user_social->user_id          = $user->id;

            $user_social->facebook          = $request->facebook;
            
            $user_social->facebook_follwers  = $request->facebook_follwers;

            $user_social->twitter            = $request->twitter;

            $user_social->twitter_follwers   = $request->twitter_follwers;

            $user_social->instgrame           = $request->instgrame;

            $user_social->instgrame_follwers  =$request->instgrame_follwers;

            $user_social->snapchat            = $request->snapchat;

            $user_social->snapchat_follwers   = $request->snapchat_follwers;

            $user_social->linkedin             = $request->linkedin;

            $user_social->linkedin_follwers   = $request->linkedin_follwers;

            $user_social->youtube             = $request->youtube;

            $user_social->youtube_follwers   = $request->youtube_follwers;

            
            //$user = User::find( $user->id );
            $user_social->save();

            //$user->save();
            return $this->respondWithSuccess(trans('api_msgs.social_admin_approve'));

    }


    public function isEmailExists( $email , $user_id )
    {
        return User::where([['id','<>',$user_id] ,['email' ,$email]])->first() ?  true : false ;
    }

    public function isPhoneExists( $phone , $user_id , $account_type = '0')
    {
        return DB::table('users')->where([['id','<>',$user_id] ,['phone' ,$phone] ,['account_type' ,$account_type]])->first() ?  true : false ;

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

            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.wrong_password'));

        }

    }


    public function updateInfluncerPassword( Request $request )
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

				if ( $request->limit ) {
					$this->setPagination($request->limit);
				}


                // $pagination =  Notification::where('user_id' , $user->id)
				// 						->orderBy('updated_at','DESC')
                // 						->paginate($this->getPagination());

                //DB::raw('CONCAT("[", GROUP_CONCAT(CONCAT({id:", species.id, ", name:", species.name, "})
//SEPARATOR ", "), "]") AS species')
        $pagination =  Notification::select('notifications.*')
                                        ->join('users as to', 'to.id', '=', 'notifications.user_id')
                                        ->leftjoin('users as from', 'from.id', '=', 'notifications.from_user_id')
                                        ->where('notifications.user_id' , $user->id)
                                        ->orderBy('notifications.updated_at','DESC')
                                        ->orderBy('notifications.id', 'DESC')
										->paginate($this->getPagination());

				$notifications =  $pagination->items();

				foreach ($notifications as $key => $value) {
						$notifications_array[] = $value->id;
				}
				if(!empty($notifications_array))
				{
						$notifications_array = Notification::where('user_id' , $user->id)->whereIn('id', $notifications_array)->update(['is_seen' => '1']);
				}
        $notifications =  $this->notificationsTransformer->transformCollection(collect($pagination->items()));
        return $this->respondWithPagination($pagination, ['data' => $notifications ]);
    }


    function influncerUserProfile(Request $request)
    {

        $validator = Validator::make( ['id' =>  $request->id ], [
            'id'    => 'required|exists:users,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('paramters failed validation');
        }
        $this->profileTransformer->setFlag(true);
        $data = $this->profileTransformer->transform(User::find($request->id));
        return $this->sendResponse($data,trans('lang.read succefully'),200);
    }


    function UserinfluncerProfile(Request $request)
    {
        $validator = Validator::make( ['id' =>  $request->id ], [
            'id'    => 'required|exists:users,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('paramters failed validation');
        }

        $this->influncerTransformer->setFlag(true);
        $data = $this->influncerTransformer->transform(User::find($request->id));
        return $this->sendResponse($data,trans('lang.read succefully'),200);
    }



    //  update user and influencer mobile number

    function updatePhone (Request $request)
    {
        $user =  $this->getAuthenticatedUser();

        $validator = Validator::make( $request->all(), [
            'country_id' => 'required',
            'phone'      => 'required',
        ]);

        
        $account_type = '0';
        if($request->header('account-type'))
        {
            $account_type = $request->header('account-type');
        }

        if ($this->isPhoneExists( $request->phone ,$user->id , $account_type)) {
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.phone_exists'));
        }

        if($request->phone == $user->phone)
        {
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.nothing_to_update'));
        }

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages()->first());
            //return $this->setStatusCode(422)->respondWithError($validator->messages());
            //return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }


        app('App\Http\Controllers\API\V1\AuthController')->createVerificationCode($request->phone,$user->countries_id,$account_type);

        return $this->respondWithSuccess(trans('api_msgs.sms_code_text'));




    }


    function getNotificationsCount(Request $request)
    {
        $user =  $this->getAuthenticatedUser();

        $notifications = Notification::select('id')->where('is_seen',0)->where('user_id',$user->id)->count();

        //dd($notifications);
        return $this->sendResponse(['notifications' => $notifications ],trans('lang.read succefully'),200);

    }



}
