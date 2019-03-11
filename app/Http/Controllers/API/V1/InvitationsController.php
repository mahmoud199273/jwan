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
        // responseHelper::$Headers = ["key1"=>"var1"];
        // return responseHelper::Success("created",["message"=>"hello world"]);
        $validator = Validator::make($request->all(), ['verificationCode' => 'required|regex:/^[0-9]{4,}/']);
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




    public function show( Request $request , $id )
    {

        $validator = Validator::make( ['id' =>  $request->id ], [
            'id'    => 'required|exists:offers,id',
        ]);
        return $validator->fails() ? $this->setStatusCode(422)->respondWithError('parameters faild validation') :
                                        $this->sendResponse( $this->offersTransformer->transform(Offer::find($request->id)),trans('lang.read succefully'),200);

    }







    public function index(Request $request)
    {
    # code...
        $user =  $this->getAuthenticatedUser();
        if($user->account_type != 0)
        {
            return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
        }
        if ( $request->limit ) {
                $this->setPagination($request->limit);
            }

            $data = Offer::where([['campaign_id',$request->campaign_id]
                ,['user_id' ,$user->id]])->get();
        /*$data = DB::table('campaigns')
        ->join('offers','campains.id','offers.campaing_id')
        ->select('offers.*')
        ->*/

        $offers = $this->offersTransformer->transformCollection($data);

        return $this->sendResponse($offers, trans('lang.offers read succesfully'),200);
    }



        public function approve(Request $request)
        {
            $user =  $this->getAuthenticatedUser();
            // security check

            $offer = Offer::where([['id',$request->id], ['status', "0"]])->get()->first();
            if(!$offer){
                return $this->setStatusCode(422)->respondWithError(trans('api_msgs.offer is not found or approved before'));
            }
            // $userData = User::find($user->id);
            // if($userData->balance<$offer->cost)
            // {
            //   return $this->setStatusCode(422)->respondWithError(trans('api_msgs.please charge your account'));
            // }

            $offer->status = "1";
            $offer->save();


            $campaign = Campaign::where('id', $offer->campaign_id)->get()->first();



            // $transations = new Transactions;
            // $transations->user_id = $user->id;
            // $transations->amount     = $offer->cost;
            // $transations->direction = 1;
            // $transations->type     = 1;
            // $transations->status     = 0;
            // $transations->campaign_id     = $campaign->id;
            // $transations->offer_id     = $offer->id;
            // $transations->save();

            // $user->balance = $userData->balance - $offer->cost;
            // $user->save();

            $chat_content = 'تم الموافقة على عرضك على حملة '.$campaign->title;
            $chat = new Chat;
            $chat->from_user_id	= $user->id;
            $chat->to_user_id = $offer->influncer_id;
            $chat->offer_id = $offer->id;
            $chat->campaign_id = $campaign->id;
            $chat->created_at   = Carbon::now()->addHours(3);
            $chat->updated_at   = Carbon::now()->addHours(3);
            $chat->content = Crypt::encryptString('تم الموافقة على عرضك على حملة '.$campaign->title);
            $chat->type = 1;
            $chat->save();

            $player_ids = $this->getUserPlayerIds($offer->influncer_id);
            Notification::create(['user_id' => $offer->influncer_id,
                                      'from_user_id' => $user->id,  
                                      'message' => 'Your offer approved on '.$campaign->title,
                                      'message_ar' => 'تم الموافقة على عرضك على حملة '.$campaign->title,
                                      'campaign_id' =>  $campaign->id,
                                      'offer_id'    => $offer->id,
                                      'type'          =>  1,
                                      'type_title'	=> 'offer approved']);
            sendNotification(1,
                                  'Your offer approved on '.$campaign->title,
                                  'تم الموافقة على عرضك على حملة '.$campaign->title,
                                  $player_ids,"offers",
                                  ['campaign_id' =>  (int)$campaign->id,
                                  'campaign_title' => $campaign->title,
                                  'offer_id'    => (int)$offer->id,
                                  'type'          =>  1,
                                  'type_title'	=> 'offer approved']);

            //////////////////// new push /////////////////////////////////////
            return $this->respondWithSuccess(trans('api_msgs.updated'));
        }



                public function reject(Request $request)
                {
                    $user =  $this->getAuthenticatedUser();

                    if($user->account_type != 0)
                    {
                        return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
                    }

                    // security check
                    $offer = Offer::where([['id',$request->id], ['status', "0"]])->get()->first();
                    if(!$offer){
                        return $this->setStatusCode(422)->respondWithError(trans('api_msgs.offer is not found or approved before'));
                    }
                    $offer->status = "2";
                    $offer->save();

                    $campaign = Campaign::where('id', $offer->campaign_id)->get()->first();

                    $chat_content = 'تم رفض عرضك على حملة '.$campaign->title;
                    $chat = new Chat;
                    $chat->from_user_id	= $user->id;
                    $chat->to_user_id = $offer->influncer_id;
                    $chat->offer_id = $offer->id;
                    $chat->campaign_id = $campaign->id;
                    $chat->created_at   = Carbon::now()->addHours(3);
                    $chat->updated_at   = Carbon::now()->addHours(3);
                    $chat->content = Crypt::encryptString($chat_content);
                    $chat->type = 1;
                    $chat->save();

                    $player_ids = $this->getUserPlayerIds($offer->influncer_id);
                    Notification::create(['user_id' => $offer->influncer_id,
                                              'from_user_id' => $user->id, 
                                              'message' => 'Your offer rejected on '.$campaign->title,
                                              'message_ar' => 'تم رفض عرضك على حملة '.$campaign->title,
                                              'campaign_id' =>  $campaign->id,
                                              'offer_id'    => $offer->id,
                                              'type'          =>  2,
                                              'type_title'	=> 'rejected offer']);
                    sendNotification(1,
                                          'Your offer rejected on '.$campaign->title,
                                          'تم رفض عرضك على حملة '.$campaign->title,
                                          $player_ids,"offers",
                                          ['campaign_id' =>  (int)$campaign->id,
                                          'offer_id'    => (int)$offer->id,
                                          'campaign_title' => $campaign->title,
                                          'type'          =>  2,
                                          'type_title'	=> 'rejected offer']);

                    //////////////////// new push /////////////////////////////////////
                    return $this->respondWithSuccess(trans('api_msgs.updated'));
                }

        public function pay(Request $request)
        {
            $user =  $this->getAuthenticatedUser();

            if($user->account_type != 0)
            {
                return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
            }

            $validator = Validator::make( $request->all(), [
                'id'                        => 'required|exists:offers,id',
                'sdk_token'                 => 'nullable',
                'merchant_reference'        => 'nullable',
                'card_holder_name'          => 'nullable',
                'card_number'               => 'nullable',
                'authorization_code'        => 'nullable',
                'response_code'             => 'nullable',
                'payment_option'            => 'nullable',
                'fort_id'                   => 'nullable',
                'amount'                    => 'nullable',
                'eci'                       => 'nullable',
                'customer_ip'               => 'nullable',
                'command'                   => 'nullable',
            ]);

            // security check
            $offer = Offer::where([['id',$request->id], ['status', "1"]])->get()->first();
            if(!$offer){
                return $this->setStatusCode(422)->respondWithError(trans('api_msgs.offer is not found or not approved'));
            }
            
            $userData = User::find($user->id);

            $settings = Setting::first();
            //$commission = (int)$settings->commission; // app commission value in percentage

            // app commission value in percentage
            // if($user->user_commission)
            // {
            //     $commission = (int)$user->user_commission; // if there user commission use it 
            // }
            // else
            // {
            //     $commission = (int)$settings->commission; // if there not user commission use commission in settings 
            // }
            $tax = (int)$settings->tax; // app tax value in percentage

            // offer cost before add commission or tax
            $total_offer_value =(int)$offer->cost; 

            // get commission value of offer
            //$offer_commission = round((($total_offer_value * $commission) / 100), 2); 
            $offer_commission = 0; 

            // offer cost after add commission vlaue
            $total_offer_value = $total_offer_value + $offer_commission ; 

            // get tax value from offer cost 
            $offer_tax = round((($total_offer_value * $tax) / 100), 2);

            // final offer cost after add commission and tax values
            $total_offer_value = $total_offer_value + $offer_tax ;
            
            //if((int)$offer->cost > (int)$userData->balance)
            if($total_offer_value > (int)$userData->balance && !$request->fort_id)
            {
                return $this->setStatusCode(403)->respondWithError(trans('api_msgs.offer_not_pay'));
            }
            
            $offer->status = "3";
            $offer->save();
            ///////////////////////////////////// payment success or redirect /////////////////////////////////////



            $campaign = Campaign::where('id', $offer->campaign_id)->get()->first();


            $transations = new Transactions;
            $transations->user_id = $user->id;
            if($offer->cost) $transations->amount     = $offer->cost;
            else $transations->amount     = 0;
            $transations->direction = 1;
            $transations->type     = 1;
            $transations->status     = 0;
            $transations->campaign_id     = $offer->campaign_id;
            $transations->offer_id     = $offer->id;

            if($request->amount) $transations->transaction_amount     = $request->amount;
            else $transations->transaction_amount     = $total_offer_value;

            // payfort response
            if($request->card_holder_name){
                $transations->card_holder_name     = $request->card_holder_name;
                $transations->transaction_account_name     = $request->card_holder_name;
            }    
            if($request->sdk_token) 
                $transations->sdk_token     = $request->sdk_token;
            if($request->merchant_reference) 
                $transations->merchant_reference     = $request->merchant_reference;
            if($request->card_number){ 
                $transations->card_number     = $request->card_number;
                $transations->transaction_account_number     = $request->transaction_account_number;
            }    
            if($request->authorization_code) 
                $transations->authorization_code     = $request->authorization_code;
            if($request->response_code) 
                $transations->response_code     = $request->response_code;
            if($request->payment_option) 
                $transations->payment_option     = $request->payment_option;
            if($request->fort_id) 
                $transations->fort_id     = $request->fort_id;
            if($request->eci) 
                $transations->eci     = $request->eci;
            if($request->customer_ip) 
                $transations->customer_ip     = $request->customer_ip;
            if($request->command) 
                $transations->command     = $request->command;
            // payfort response

            $transations->save();
            
            //$user->balance = $userData->balance - $offer->cost;
            if(!$request->fort_id)
            {
                $user->balance = $userData->balance - $total_offer_value;
                $user->save();
            }
            
            // $influncerData = User::find($offer->influncer_id);
            // $influncer_balance = $influncerData->balance + $offer->cost;
            // User::where('id' , $user->id)->whereIn('id', $offer->influncer_id)->update(['balance' => $influncer_balance]);

            $chat_content = 'تم سداد قيمة عرضك على حملة '.$campaign->title;
            $chat = new Chat;
            $chat->from_user_id	= $user->id;
            $chat->to_user_id = $offer->influncer_id;
            $chat->offer_id = $offer->id;
            $chat->campaign_id = $campaign->id;
            $chat->created_at   = Carbon::now()->addHours(3);
            $chat->updated_at   = Carbon::now()->addHours(3);
            $chat->content = Crypt::encryptString($chat_content);
            $chat->type = 1;
            $chat->save();

            $player_ids = $this->getUserPlayerIds($offer->influncer_id);
            Notification::create(['user_id' => $offer->influncer_id,
                                      'from_user_id' => $user->id,    
                                      'message' => 'Your offer paid on '.$campaign->title,
                                      'message_ar' => 'تم سداد قيمة عرضك على حملة '.$campaign->title,
                                      'campaign_id' =>  $campaign->id,
                                      'offer_id'    => $offer->id,
                                      'type'          =>  3,
                                      'type_title'	=> 'paid offer']);
            sendNotification(1,
                                  'Your offer paid on '.$campaign->title,
                                  'تم سداد قيمة عرضك على حملة '.$campaign->title,
                                  $player_ids,"offers",
                                  ['campaign_id' =>  (int)$campaign->id,
                                  'offer_id'    => (int)$offer->id,
                                  'campaign_title' => $campaign->title,
                                  'type'          =>  3,
                                  'type_title'	=> 'paid offer']);
            //////////////////// new push /////////////////////////////////////
            return $this->respondWithSuccess(trans('api_msgs.updated'));
        }


        public function finish(Request $request)
        {
            $user =  $this->getAuthenticatedUser();

            if($user->account_type != 0)
            {
                return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
            }
            // security check
            $validator = Validator::make( $request->all(), [
                'id'                => 'required|exists:offers,id',
                'rate'              => 'required|integer|between:1,5',
                'comment'           => 'nullable|string'
            ]);

            if ($validator->fails()) {
              // return redirect()->back()->withInput($request->input())->withErrors($validator);
                return $this->setStatusCode(422)->respondWithError(trans('parameters faild validation'));
            }

            $offer = Offer::where([['id',$request->id], ['status', "5"]])->get()->first();
            if(!$offer){
              return $this->setStatusCode(422)->respondWithError(trans('api_msgs.offer is not found or not proofed'));
            }
            $offer->status = "7";
            $offer->user_rate = (int)$request->rate;
            $offer->user_rate_comment = $request->comment;
            $offer->save();

            //find my tranaction
            $user_transation = Transactions::where([['user_id', $user->id], ['offer_id', $offer->id]])->get()->first();
            $user_transation->status = 1;
            $user_transation->save();


            $influncer_transations = new Transactions;
            $influncer_transations->user_id = $offer->influncer_id;
            //$influncer_transations->amount     = $offer->cost;
            if($offer->cost) $influncer_transations->amount     = $offer->cost;
            else $influncer_transations->amount     = 0;
            
            $influncer_transations->direction = 0;
            $influncer_transations->type     = 2;
            $influncer_transations->status     = 1;
            $influncer_transations->campaign_id     = $offer->campaign_id;
            $influncer_transations->offer_id     = $offer->id;
            $influncer_transations->save();



            $influncer = User::find($offer->influncer_id);
            $settings = Setting::first();
            // app commission value in percentage
            if($influncer->user_commission)
            {
                $commission = (int)$influncer->user_commission; // if there user commission use it 
            }
            else
            {
                $commission = (int)$settings->commission; // if there not user commission use commission in settings 
            }
            // get offer commission from influncer
            $offer_cost = $offer->cost;
            $offer_commission = round((($offer_cost * $commission) / 100), 2);
            $total_offer_value = $offer->cost - $offer_commission;

            $influncer->balance = $influncer->balance+$total_offer_value;
            $influncer->save();

            if(strlen($request->comment)!=0)
            {
            $chat = new Chat;
            $chat->from_user_id	= $offer->user_id;
            $chat->to_user_id = $offer->influncer_id;
            $chat->offer_id = $offer->id;
            $chat->campaign_id = $offer->campaign_id;
            $chat->created_at   = Carbon::now()->addHours(3);
            $chat->updated_at   = Carbon::now()->addHours(3);
            $chat->content = Crypt::encryptString($request->comment);
            $chat->type = 1;
            $chat->save();
            }
            ///////////////////////////////////// payment success or redirect /////////////////////////////////////



            $campaign = Campaign::where('id', $offer->campaign_id)->get()->first();

            $player_ids = $this->getUserPlayerIds($offer->influncer_id);
            Notification::create(['user_id' => $offer->influncer_id,
                                      'from_user_id' => $user->id,   
                                      'message' => 'Your proof have been approved and finished on '.$campaign->title,
                                      'message_ar' => 'تم قبول توثيقك يجب التقييم لكى يتم اغلاق الحمله  '.$campaign->title,
                                      'campaign_id' =>  $campaign->id,
                                      'offer_id'    => $offer->id,
                                      'type'          =>  7,
                                      'type_title'	=> 'finished offer']);
            sendNotification(1,
                                  'Your proof have been approved and finished on '.$campaign->title,
                                  'تم قبول توثيقك يجب التقييم لكى يتم اغلاق الحمله '.$campaign->title,
                                  $player_ids,"offers",
                                  ['campaign_id' =>  (int)$campaign->id,
                                  'offer_id'    => (int)$offer->id,
                                  'campaign_title' => $campaign->title,
                                  'type'          =>  7,
                                  'type_title'	=> 'finished offer',
                                  'chat_content'         => $request->comment,
                                  'chat_type'       => 1]);
            //////////////////// new push /////////////////////////////////////
            return $this->respondWithSuccess(trans('api_msgs.updated'));
        }


        public function user_rate(Request $request)
        {
            $user =  $this->getAuthenticatedUser();

            if($user->account_type != 0)
            {
                return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
            }
            // security check
            $validator = Validator::make( $request->all(), [
                'id'                => 'required|exists:offers,id',
                'rate'              => 'required|integer|between:1,5',
                'comment'           => 'nullable|string'
            ]);

            if ($validator->fails()) {
              return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
            }

            $offer = Offer::where([['id',$request->id], ['user_rate', null]])->get()->first();
            if(!$offer){
              return $this->setStatusCode(422)->respondWithError(trans('api_msgs.offer is not found or not allowed to rate'));
            }
            $offer->user_rate = (int)$request->rate;
            $offer->user_rate_comment = $request->comment;
            $offer->save();

            if(strlen($request->comment)!=0)
            {
            $chat = new Chat;
            $chat->from_user_id	= $offer->influncer_id;
            $chat->to_user_id = $offer->user_id;
            $chat->offer_id = $offer->id;
            $chat->campaign_id = $offer->campaign_id;
            $chat->created_at   = Carbon::now()->addHours(3);
            $chat->updated_at   = Carbon::now()->addHours(3);
            $chat->content = Crypt::encryptString($request->comment);
            $chat->type = 1;
            $chat->save();
            }
            ///////////////////////////////////// payment success or redirect /////////////////////////////////////
            //////////////////// new push /////////////////////////////////////
            return $this->respondWithSuccess(trans('api_msgs.updated'));
        }




        public function user_cancel(Request $request)
        {
            $user =  $this->getAuthenticatedUser();

            if($user->account_type != 0)
            {
                return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
            }
            // security check should be influncer and owner of request
            $offer = Offer::
                            where([['id',$request->id], ['status', "1"]])
                            ->orWhere([['id',$request->id], ['status', "3"]])
                            ->get()->first();
            if(!$offer){
                return $this->setStatusCode(422)->respondWithError(trans('api_msgs.offer is not found or you not allowed now'));
            }
            $offer->status = "9";
            $offer->user_rate = 0;
            $offer->save();
            ///////////////////////////////////// payment success or redirect /////////////////////////////////////



            $campaign = Campaign::where('id', $offer->campaign_id)->get()->first();

            $chat_content = 'تم الغاء عرضك على حملة '.$campaign->title;
            $chat = new Chat;
            $chat->from_user_id	= $user->id;
            $chat->to_user_id = $offer->influncer_id;
            $chat->offer_id = $offer->id;
            $chat->campaign_id = $campaign->id;
            $chat->created_at   = Carbon::now()->addHours(3);
            $chat->updated_at   = Carbon::now()->addHours(3);
            $chat->content = Crypt::encryptString($chat_content);
            $chat->type = 1;
            $chat->save();

            $player_ids = $this->getUserPlayerIds($offer->influncer_id);
            Notification::create(['user_id' => $offer->influncer_id,
                                      'from_user_id' => $user->id, 
                                      'message' => 'user has canceled '.$campaign->title,
                                      'message_ar' => 'تم الغاء عرضك على حملة '.$campaign->title,
                                      'campaign_id' =>  $campaign->id,
                                      'offer_id'    => $offer->id,
                                      'type'          =>  9,
                                      'type_title'	=> 'canceled offer']);
            sendNotification(1,
                                  'user has canceled '.$campaign->title,
                                  'تم الغاء عرضك على حملة '.$campaign->title,
                                  $player_ids,"offers",
                                  ['campaign_id' =>  (int)$campaign->id,
                                  'offer_id'    => (int)$offer->id,
                                  'campaign_title' => $campaign->title,
                                  'type'          =>  9,
                                  'type_title'	=> 'canceled offer']);
            //////////////////// new push /////////////////////////////////////
            return $this->respondWithSuccess(trans('api_msgs.updated'));
        }




                public function inprogress(Request $request)
                {
                    $user =  $this->getAuthenticatedUser();

                    if($user->account_type != 1)
                    {
                        return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
                    }

                    // security check should be influncer and owner of request
                    $offer = Offer::where([['id',$request->id], ['status', "3"]])->get()->first();
                    if(!$offer){
                        return $this->setStatusCode(422)->respondWithError(trans('api_msgs.offer is not found or not approved'));
                    }
                    $offer->status = "4";
                    $offer->save();
                    ///////////////////////////////////// payment success or redirect /////////////////////////////////////

                    $campaign = Campaign::where('id', $offer->campaign_id)->get()->first();

                    $chat_content = 'جاري العمل على الحملة '.$campaign->title;
                    $chat = new Chat;
                    $chat->from_user_id	= $campaign->user_id;
                    $chat->to_user_id = $user->id;
                    $chat->offer_id = $offer->id;
                    $chat->campaign_id = $campaign->id;
                    $chat->created_at   = Carbon::now()->addHours(3);
                    $chat->updated_at   = Carbon::now()->addHours(3);
                    $chat->content = Crypt::encryptString($chat_content);
                    $chat->type = 1;
                    $chat->save();

                    $player_ids = $this->getUserPlayerIds($campaign->user_id);
                    Notification::create(['user_id' => $campaign->user_id,
                                              'from_user_id' => $user->id,   
                                              'message' => 'influner is working on '.$campaign->title,
                                              'message_ar' => 'جاري العمل على الحملة '.$campaign->title,
                                              'campaign_id' =>  $campaign->id,
                                              'offer_id'    => $offer->id,
                                              'type'          =>  4,
                                              'type_title'	=> 'inprogress offer']);
                    sendNotification(0,
                                          'influner is working on '.$campaign->title,
                                          'جاري العمل على الحملة '.$campaign->title,
                                          $player_ids,"offers",
                                          ['campaign_id' =>  (int)$campaign->id,
                                          'offer_id'    => (int)$offer->id,
                                          'campaign_title' => $campaign->title,
                                          'type'          =>  4,
                                          'type_title'	=> 'inprogress offer']);
                    //////////////////// new push /////////////////////////////////////
                    return $this->respondWithSuccess(trans('api_msgs.updated'));
                }

                /*public function get_inprogresses( Request $reqest )
                {
                    $influncer = $this->getAuthenticatedUser();
                    $offers = Offer::where([['influncer_id',$influncer->id],

                        ['status', "4"]
                    ])->get();

                    // dd($offers);

                    if(!$offers){
                        return $this->setStatusCode(422)->respondWithError(trans('api_msgs.offer is not found or not approved'));
                    }
                    return $this->sendResponse( $this->offersTransformer->transformCollection($offers),trans('lang.read succefully'),200);

                }*/

                public function proof(Request $request)
                {
                    $user =  $this->getAuthenticatedUser();

                    if($user->account_type != 1)
                    {
                        return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
                    }

                    // security check should be influncer and owner of request
                    $offer = Offer::where([['id',$request->id], ['status', "4"]])->get()->first();
                    if(!$offer){
                        return $this->setStatusCode(422)->respondWithError(trans('api_msgs.offer is not found or not being working on'));
                    }
                    $offer->status = "5";
                    $offer->save();
                    ///////////////////////////////////// payment success or redirect /////////////////////////////////////


                    $campaign = Campaign::where('id', $offer->campaign_id)->get()->first();

                    $chat_content = 'تم الانتهاء و توثيق حملة '.$campaign->title;
                    $chat = new Chat;
                    $chat->from_user_id	= $campaign->user_id;
                    $chat->to_user_id = $user->id;
                    $chat->offer_id = $offer->id;
                    $chat->campaign_id = $campaign->id;
                    $chat->created_at   = Carbon::now()->addHours(3);
                    $chat->updated_at   = Carbon::now()->addHours(3);
                    $chat->content = Crypt::encryptString($chat_content);
                    $chat->type = 1;
                    $chat->save();

                    $player_ids = $this->getUserPlayerIds($campaign->user_id);
                    Notification::create(['user_id' => $campaign->user_id,
                                              'from_user_id' => $user->id, 
                                              'message' => 'influner has finished and proofed '.$campaign->title,
                                              'message_ar' => 'تم الانتهاء و توثيق حملة '.$campaign->title,
                                              'campaign_id' =>  $campaign->id,
                                              'offer_id'    => $offer->id,
                                              'type'          =>  5,
                                              'type_title'	=> 'proofed offer']);
                    sendNotification(0,
                                          'influner has finished and proofed '.$campaign->title,
                                          'تم الانتهاء و توثيق حملة '.$campaign->title,
                                          $player_ids,"offers",
                                          ['campaign_id' =>  (int)$campaign->id,
                                          'offer_id'    => (int)$offer->id,
                                          'campaign_title' => $campaign->title,
                                          'type'          =>  5,
                                          'type_title'	=> 'proofed offer']);
                    //////////////////// new push /////////////////////////////////////
                    return $this->respondWithSuccess(trans('api_msgs.updated'));
                }

                /*public function get_proofed(Request $reqest )
                {
                    $influncer = $this->getAuthenticatedUser();
                    $offers = Offer::where([['influncer_id',$influncer->id],

                        ['status', "5"]
                    ])->get();

                    // dd($offers);

                    if(!$offers){
                        return $this->setStatusCode(422)->respondWithError(trans('api_msgs.offer is not found or not approved'));
                    }
                    return $this->sendResponse( $this->offersTransformer->transformCollection($offers),trans('lang.read succefully'),200);
                }*/

                public function influncer_cancel(Request $request)
                {
                    $user =  $this->getAuthenticatedUser();

                    if($user->account_type != 1)
                    {
                        return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
                    }

                    // security check should be influncer and owner of request
                    $offer = Offer::
                                    where([['id',$request->id], ['status', "0"]])
                                    ->orWhere([['id',$request->id], ['status', "1"]])
                                    ->orWhere([['id',$request->id], ['status', "3"]])
                                    ->get()->first();
                    if(!$offer){
                        return $this->setStatusCode(422)->respondWithError(trans('api_msgs.offer is not found or you not allowed now'));
                    }
                    $offer->influncer_rate = 0;
                    $offer->status = "8";
                    $offer->save();
                    ///////////////////////////////////// payment success or redirect /////////////////////////////////////





                    $campaign = Campaign::where('id', $offer->campaign_id)->get()->first();

                    $chat_content = 'قام المؤثر بالغاء عرضه على '.$campaign->title;
                    $chat = new Chat;
                    $chat->from_user_id	= $campaign->user_id;
                    $chat->to_user_id = $user->id;
                    $chat->offer_id = $offer->id;
                    $chat->campaign_id = $campaign->id;
                    $chat->created_at   = Carbon::now()->addHours(3);
                    $chat->updated_at   = Carbon::now()->addHours(3);
                    $chat->content = Crypt::encryptString($chat_content);
                    $chat->type = 1;
                    $chat->save();


                    $player_ids = $this->getUserPlayerIds($campaign->user_id);
                    Notification::create(['user_id' => $campaign->user_id,
                                              'from_user_id' => $user->id, 
                                              'message' => 'influner has canceled offer on '.$campaign->title,
                                              'message_ar' => 'قام المؤثر بالغاء عرضه على '.$campaign->title,
                                              'campaign_id' =>  $campaign->id,
                                              'offer_id'    => $offer->id,
                                              'type'          =>  8,
                                              'type_title'	=> 'canceled offer']);
                    sendNotification(0,
                                          'influner has canceled offer on '.$campaign->title,
                                          'قام المؤثر بالغاء عرضه على '.$campaign->title,
                                          $player_ids,"offers",
                                          ['campaign_id' =>  (int)$campaign->id,
                                          'offer_id'    => (int)$offer->id,
                                          'campaign_title' => $campaign->title,
                                          'type'          =>  8,
                                          'type_title'	=> 'canceled offer']);
                    //////////////////// new push /////////////////////////////////////
                    return $this->respondWithSuccess(trans('api_msgs.updated'));
                }


               /* public function canceledOffers(Request $reqest)
                {
                    $influncer = $this->getAuthenticatedUser();
                    $offers = Offer::where([['influncer_id',$influncer->id],

                        ['status', "8"]
                    ])->get();

                    // dd($offers);

                    if(!$offers){
                        return $this->setStatusCode(422)->respondWithError(trans('api_msgs.offer is not found or not approved'));
                    }
                    return $this->sendResponse( $this->offersTransformer->transformCollection($offers),trans('lang.read succefully'),200);
                }*/




                public function influncer_rate(Request $request)
                {
                    $user =  $this->getAuthenticatedUser();

                    if($user->account_type != 1)
                    {
                        return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
                    }
                    
                    // security check
                    $validator = Validator::make( $request->all(), [
                        'id'                => 'required|exists:offers,id',
                        'rate'              => 'required|integer|between:1,5',
                        'comment'           => 'nullable|string'
                    ]);

                    if ($validator->fails()) {
                       return $this->setStatusCode(422)->respondWithError($validator->messages());
                        return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
                    }

                    $offer = Offer::where([['id',$request->id], ['influncer_rate', null]])->get()->first();
                    if(!$offer){
                      return $this->setStatusCode(422)->respondWithError(trans('api_msgs.offer is not found or not allowed to rate'));
                    }
                    $offer->influncer_rate = (int)$request->rate;
                    $offer->influncer_rate_comment = $request->comment;
                    $offer->save();

                    if(strlen($request->comment)!=0)
                    {
                    $chat = new Chat;
                    $chat->from_user_id	= $offer->influncer_id;
                    $chat->to_user_id = $offer->user_id;
                    $chat->offer_id = $offer->id;
                    $chat->campaign_id = $offer->campaign_id;
                    $chat->created_at   = Carbon::now()->addHours(3);
                    $chat->updated_at   = Carbon::now()->addHours(3);
                    $chat->content = Crypt::encryptString($request->comment);
                    $chat->type = 1;
                    $chat->save();
                    }
                    ///////////////////////////////////// payment success or redirect /////////////////////////////////////
                    //////////////////// new push /////////////////////////////////////
                    return $this->respondWithSuccess(trans('api_msgs.updated'));
                }




    public function store( Request $request )
    {
        $influncer =  $this->getAuthenticatedUser();

        if($influncer->account_type == '0'){
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.you do not have the rigtt to be here'));
        }

        $validator = Validator::make( $request->all(), [

            'campaign_id'      =>'required',

            'cost'             =>'nullable',

            'description'      =>'required',

            'facebook'          => 'nullable',

            'twitter'           => 'nullable',

            'snapchat'          => 'nullable',

            'youtube'           => 'nullable',

            'instgrame'         => 'nullable',
        ]);

        if($this->influncerHasOffer($influncer->id,$request->campaign_id)){
            return $this->setStatusCode(422)->respondWithError('Already offerd before');
        }

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }

        $campaign = Campaign::where('id', $request->campaign_id)->get()->first();

        $offer = new Offer;
        $offer->campaign_id     = $request->campaign_id;
        $offer->user_id         = $campaign->user_id;
        $offer->influncer_id    = $influncer->id;
        $offer->cost            = str_replace(",",".",$request->cost);
        $offer->description     = $request->description;
        if($request->facebook) $offer->facebook        = $request->facebook;
        if($request->twitter) $offer->twitter         = $request->twitter;
        if($request->snapchat) $offer->snapchat        = $request->snapchat;
        if($request->youtube) $offer->youtube         = $request->youtube;
        if($request->instgrame) $offer->instgrame       = $request->instgrame;
        $offer->created_at      = Carbon::now()->addHours(3);
        $offer->save();

        //$request->description
        if(strlen($request->description)!=0)
        {
        $chat = new Chat;
        $chat->from_user_id	= $influncer->id;
        $chat->to_user_id = $campaign->user_id;
        $chat->offer_id = $offer->id;
        $chat->campaign_id = $request->campaign_id;
        $chat->created_at   = Carbon::now()->addHours(3);
        $chat->updated_at   = Carbon::now()->addHours(3);
        $chat->content = Crypt::encryptString($request->description);
        $chat->type = 1;
        $chat->save();
        }


        $player_ids = $this->getUserPlayerIds($campaign->user_id);
        Notification::create(['user_id' => $campaign->user_id,
                              'from_user_id' => $influncer->id, 
																	'message' => 'A new offer was added on '.$campaign->title,
																	'message_ar' => 'يوجد عرض جديد على حملة '.$campaign->title,
																	'campaign_id' =>  $campaign->id,
                                  'offer_id'    => $offer->id,
                                  'type'          =>  0,
																	'type_title'	=> 'new offer']);
        sendNotification(0,
                              'A new offer was added on '.$campaign->title,
															'يوجد عرض جديد على حملة '.$campaign->title,
															$player_ids,"offers",
															['campaign_id' =>  (int)$campaign->id,
                              'offer_id'    => (int)$offer->id,
                              'campaign_title' => $campaign->title,
                              'type'          =>  0,
                              'type_title'	=> 'new offer',
                              'chat_content'         => $request->description,
                              'chat_type'       => 1]);



        return $this->respondWithSuccess(trans('api_msgs.created'));

    }



    public function update( Request $request )
    {
       $influncer =  $this->getAuthenticatedUser();

       if($influncer->account_type == '0'){
           return $this->setStatusCode(422)->respondWithError(trans('api_msgs.you do not have the rigtt to be here'));
       }

       $validator = Validator::make( $request->all(), [
          'id'                => 'required|exists:offers,id',
          
          'cost'             =>'required',

          'facebook'          => 'nullable',

          'twitter'           => 'nullable',

          'snapchat'          => 'nullable',

          'youtube'           => 'nullable',

          'instgrame'         => 'nullable',
       ]);

       // if($this->influncerHasOffer($influncer->id,$request->campaign_id)){
       //     return $this->setStatusCode(422)->respondWithError('Already offerd before');
       // }

       if ($validator->fails()) {
           return $this->setStatusCode(422)->respondWithError($validator->messages());
           return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
       }



       $offer = Offer::find($request->id);
       $offer->cost            = str_replace(",",".",$request->cost);
       if(strlen($request->description)!=0)
       {
         $offer->description     = $request->description;
       }
        $offer->facebook        = $request->facebook;
        $offer->twitter         = $request->twitter;
        $offer->snapchat        = $request->snapchat;
        $offer->youtube         = $request->youtube;
        $offer->instgrame       = $request->instgrame;

       $offer->save();

       //$request->description
       //$campaign = Campaign::where('id', $request->campaign_id)->get();
       $campaign = Campaign::find($offer->campaign_id);
       
         $chat = new Chat;
         $chat->from_user_id	= $influncer->id;
         $chat->to_user_id = $campaign->user_id;
         $chat->offer_id = $offer->id;
         $chat->campaign_id = $campaign->id;
         $chat->created_at   = Carbon::now()->addHours(3);
         $chat->updated_at   = Carbon::now()->addHours(3);
         if(strlen($request->description)!=0)
        {    
           $desc = 'يوجد تعديل جديد على عرض حملة '.$campaign->title." ".$request->description; 
           $chat->content = Crypt::encryptString($desc);
        }
        else
        {
            $chat->content = Crypt::encryptString('يوجد تعديل جديد على عرض حملة '.$campaign->title);
        }   
         $chat->type = 1;
         $chat->save();
       


       $player_ids = $this->getUserPlayerIds($campaign->user_id);
       Notification::create(['user_id' => $campaign->user_id,
                                 'from_user_id' => $influncer->id,
                                 'message' => 'A new offer update on '.$campaign->title,
                                 'message_ar' => 'يوجد تعديل جديد على عرض حملة '.$campaign->title,
                                 'campaign_id' =>  $campaign->id,
                                 'offer_id'    => $offer->id,
                                 'type'          =>  1,
                                 'type_title'	=> 'update offer']);
       sendNotification(0,
                             'A new offer was added on '.$campaign->title,
                             'يوجد تعديل جديد على عرض حملة '.$campaign->title,
                             $player_ids,"offers",
                             ['campaign_id' =>  (int)$campaign->id,
                             'offer_id'    => (int)$offer->id,
                             'campaign_title' => $campaign->title,
                             'type'          =>  14,
                             'type_title'	=> 'update offer',
                             'chat_content'         => $request->description,
                             'chat_type'       => 1]);
      //////////////////////////////////// new push //////////////////////////////////////////////////////

       return $this->respondWithSuccess(trans('api_msgs.created'));


       ///////////////////// zzzzzzzz //////

     }


        public function offerStatus(Request $request)
        {
            $user =  $this->getAuthenticatedUser();

            $validator = Validator::make( $request->all(), [
            'id'                   => 'required|exists:offers,id',
            'status'               => 'required'

            ]);

            if ($validator->fails()) {
                return $this->setStatusCode(422)->respondWithError($validator->messages());
                return $this->setStatusCode(422)->respondWithError('parameters faild validation');
            }

            $offer = Offer::find($request->id);


            $offer->status         = $request->status;

            $offer->user_id        = $user->id;

            $offer->save();

            return $this->respondWithSuccess(trans('lang.set status successfully'));
        }


    public function destroy(Request $request )
    {
        $user =  $this->getAuthenticatedUser();

        $validator = Validator::make( ['id' =>  $request->id ], [
            'id'    => 'required|exists:campaigns,id',
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        Campaign::where([['id', $request->id],['user_id', $user->id]])->delete();

        return $this->respondWithSuccess(trans('api_msgs.deleted'));

    }



    // public function offerStatus(Request $request)
    // {
    //     $user =  $this->getAuthenticatedUser();
    //
    //     $validator = Validator::make( $request->all(), [
    //     'id'                   => 'required|exists:offers,id',
    //     'status'                     => 'required'
    //
    //     ]);
    //
    //     if ($validator->fails()) {
    //         return $this->setStatusCode(422)->respondWithError($validator->messages());
    //         return $this->setStatusCode(422)->respondWithError('parameters faild validation');
    //     }
    //
    //     $offer = Offer::find($request->id);
    //
    //
    //     $offer->status         = $request->status;
    //
    //     $offer->user_id        = $user->id;
    //
    //     $offer->save();
    //
    //     return $this->respondWithSuccess(trans('lang.set status successfully'));
    // }


}
