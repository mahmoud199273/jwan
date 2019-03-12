<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as Controller;
// use App\Transformers\OffersTransformer;
// use App\User;
// use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Validation\Rule;
// use Illuminate\Support\Facades\Crypt;
use App\Helpers\ResponseHelper as responseHelper;
use App\Models\Invitations;
use App\Models\InvitationCodes;


class InvitationsController extends Controller
{
    function __construct(Request $request){
        App::setlocale($request->lang);
        // $this->middleware('jwt.auth');
    }



    public function checkVerificationCode(Request $request){
        $validator = Validator::make($request->all(), ['verificationCode' => 'required|regex:/^[0-9a-zA-Z]{4,}/']);
        if ($validator->fails()) return responseHelper::Fail("validationError",$validator->messages());

        $code = InvitationCodes::where("code", $request->verificationCode)->where("status","ACTIVE")->first();
        if($code) return responseHelper::Success("success",["message"=>"Verification Code Found."]);  
        else return responseHelper::Fail("resourceNotFound",["message"=>"this code is not registered or it's already used before."]);  
    }

    public function requestVerificationCode(Request $request){
        $rules = [ 
            'email' => 'required',
            'phone' => 'required|max:14|min:9|regex:/^[5][0-9]{4,}/',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) return responseHelper::Fail("validationError",$validator->messages());

        $trytofind = Invitations::where("email",$request->email)->orWhere("phone",$request->phone)->first();
        if($trytofind) return responseHelper::Fail("validationDublicationError",["message" => "this email or phone number was added before."]);

        $res = Invitations::create(["email"=>$request->email, "phone"=>$request->phone]);
        return responseHelper::Success("created",["message" => "invitation request was added."]);
    }


}
