<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User; 
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class APIRegisterController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request -> all(),[
         
         'phone' => 'required|string|max:25|unique:users',
         'email' =>   'required',   
         'country_id' => 'required',    
         'password'=> 'required',
         //'image' => 'required',
         //'name' =>   'required',   
         //'type' => 'required',

         //'notes' => 'required'
        ]);

        if ($validator -> fails()) {
            # code...
            return response()->json($validator->errors());
            
        }

        $user = new User();
            $user->name         =  $request->name;  
                
            $user->phone        =  $request->phone; 

            $user->email   =  $request->email; 
            
            $user->password     =  bcrypt($request->password);

            $user->image   =  $request->image; 

            $user->type     =  $request->type; 

            $user->is_active    =  '1'; 
            $user->gender     =  $request->gender;

            $user->video   =  $request->video;

            $user->facebook = $request->facebook;

            $user->facebook_follwers = $request->facebook_follwers;

            $user->twitter= $request->twitter;


            $user->twitter_follwers = $request->twitter_follwers;

            $user->instgrame = $request->instgrame;

            $user->instgrame_follwers = $request->instgrame_follwers;

            $user->snapchat = $request->snapchat;

            $user->snapchat_follwers = $request->snapchat_follwers;

            $user->linkedin = $request->linkedin;

            $user->linkedin_follwers = $request->linkedin_follwers;

            $user->youtube = $request->youtube;

            $user->youtube_follwers = $request->youtube_follwers;
            $user->notes = $request->notes;
            $user->save();
       // \Mobily::send(966555555555, 'Your Message Here');
        $user = User::first();
        $token = JWTAuth::fromUser($user);
        
        return Response::json( compact('token'));
        
        
    }

    public function showprofile($id)
    {
    	$user =  User::find($id);
    	return $this->respond(['data']);
    }

   /* public function updateProfile( Request $request , User $user )
    {
    	$user =  User::find($id);

    	$validator = Validator::make( $request->all(), [
            'name'	 =>   'required',   
            'type' 			=> 'required',
           	'image'			=> 'string',
            'notes'         => 'required'
        ]);

        
        if ($validator->fails()) {
            // return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }

       

        $user = User::find( $user->id );

        $user->name =  $request->name;
        if ( $request->full_name )   {
            $user->full_name = $request->full_name;
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

        /*if($request->hasFile('image')){
     	$filenameWithExtention = $request->file('post_image')->getClientOriginalName();
     	$fileName = pathinfo($filenameWithExtention,PATHINFO_FILENAME);
     	$extension = $request->file('post_image')->getClientOriginalExtension();
     	$fileNameStore = $fileName .'_'.time().'.'.$extension;
    	 $path = $request->file('image')->storeAs('public/image',$fileNameStore);

 		}else{
    	 $fileNameStore = 'noImage.jpg';
 		}*/

        /*if ($validator -> fails()) {
            # code...
            return response()->json($validator->errors());
            
        }

        $user = new User();
            

            $user->image   =  $request->image; 

            $user->type     =  $request->type; 

            $user->is_active    =  '1'; 
            $user->gender     =  $request->gender;

            $user->video   =  $request->video;

            $user->facebook = $request->facebook;

            $user->facebook_follwers = $request->facebook_follwers;

            $user->twitter= $request->twitter;


            $user->twitter_follwers = $request->twitter_follwers;

            $user->instgrame = $request->instgrame;

            $user->instgrame_follwers = $request->instgrame_follwers;

            $user->snapchat = $request->snapchat;

            $user->snapchat_follwers = $request->snapchat_follwers;

            $user->linkedin = $request->linkedin;

            $user->linkedin_follwers = $request->linkedin_follwers;

            $user->youtube = $request->youtube;

            $user->youtube_follwers = $request->youtube_follwers;
            $user->notes = $request->notes;
            $user->save();
       // \Mobily::send(966555555555, 'Your Message Here');
        $user = User::first();
        $token = JWTAuth::fromUser($user);
        
        return Response::json( compact('token'));
        






    }*/
}
