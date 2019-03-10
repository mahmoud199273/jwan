<?php

namespace App\Http\Controllers\API\V1;

use App\AboutApp;
use App\ContactUs;
use App\Http\Controllers\API\V1\BaseController as Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AboutAppController extends Controller
{

    protected $lang ;
    function __construct( Request $request ){
        App::setlocale($request->lang);
        $this->lang = App::getLocale();
    }


    public function index()
    {
        $about_arr = [];
        $about = AboutApp::first();
        $about_arr['body']      = $about->body;
        $about_arr['body_ar']      = $about->body_ar;
        $about_arr['facebook']  = $about ?  $about->fb_link : "http://facebook.com";
        $about_arr['twitter']   = $about ? $about->twitter_link : "http://twitter.com";
        $about_arr['google']    = $about ? $about->google_link : "http://google.com";
        $about_arr['instagram'] = $about ? $about->insta_link : "http://instagram.com";

        $about_arr['snapchat'] = $about ? $about->snap_link : "http://snapchat.com";

        return $this->respond([
            'data' => $about_arr,
        ]);
    }

    public function privacyPolicy($value='')
    {
        $privacy_policy = [];
        $about = AboutApp::first();
        $privacy_policy['title']      = $about ? $about->privacy_title : "";
        $privacy_policy['body']       = $about ?  $about->privacy_policy :"";
        $privacy_policy['title_ar']      = $about ? $about->privacy_title_ar : "";
        $privacy_policy['body_en']       = $about ?  $about->privacy_policy_ar :"";

        return $this->respond([
            'data' => $privacy_policy,
        ]);
    }


  public function influncerPrivacyPolicy($value='')
    {
        $privacy_policy = [];
        $about = AboutApp::first();
        $privacy_policy['title']      = $about ? $about->influncer_privacy_title : "";
        $privacy_policy['body']       = $about ?  $about->influncer_privacy_policy :"";
        $privacy_policy['title_ar']      = $about ? $about->influncer_privacy_title_ar : "";
        $privacy_policy['body_en']       = $about ?  $about->influncer_privacy_policy_ar :"";

        return $this->respond([
            'data' => $privacy_policy,
        ]);
    }

    public function ContactUs( Request $request )
    {
        $validator = Validator::make( $request->all(), [
            'subject'          => 'required|string',
            'message'        => 'required|string',
        ]);
        $user =  $this->getAuthenticatedUser();
        if(!$user)
        {
          return $this->setStatusCode(422)->respondWithError('you should log in');
        }

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters failed validation');
        }

        ContactUs::create(['subject' =>  $request->subject, 'message' => $request->message, 'user_id' => $user->id]);
        $emailcontent = array ('subject' => $request->subject,'msg' => $request->message);

        // @Mail::send('contact_us_email', $emailcontent, function($message) use ($request) {
        //     $message->from('a.atef@smaat.co' , 'Signify App')
        //                 ->sender('a.atef@smaat.co', 'Signify App')
        //                 ->to('a.atef@smaat.co','Signify App')
        //                 ->subject('شكوى - تواصل - '.$request->subject);
        // });

        return $this->respondWithSuccess(__('api_msgs.msg_sent'));
    }



}
