<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as Controller;
// use App\Transformers\BankAccountsTransformer;
use App\Transformers\TransactionsTransformer;
use App\User;
use App\BankAccounts;
use App\Transactions;
use App\Campaign;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;
use App\Setting;
use App\Helpers\ResponseHelper as responseHelper;


use Illuminate\Support\Facades\Log;

use App\Offer;


class TransactionsController extends Controller
{

    protected $transactionstransformer;

    function __construct(Request $request, TransactionsTransformer $transactionstransformer){
        App::setlocale($request->lang);
    	$this->middleware('jwt.auth', ["except"=>[
            "notifyDB"
        ]]);
        $this->transactionstransformer   = $transactionstransformer;
    }




    // public function show( Request $request , $id )
    // {
    //
    //     $validator = Validator::make( ['id' =>  $request->id ], [
    //         'id'    => 'required|exists:offers,id',
    //     ]);
    //     return $validator->fails() ? $this->setStatusCode(422)->respondWithError('parameters faild validation') :
    //                                     $this->sendResponse( $this->offersTransformer->transform(Offer::find($request->id)),trans('lang.read succefully'),200);
    //
    // }







    public function index(Request $request)
    {
        $user =  $this->getAuthenticatedUser();
        if ( $request->limit ) {
          $this->setPagination($request->limit);
        }

        if($user->account_type == 0) // user transactions 
        {
            $join_column = "influncer_id"; 
        }
        else // influencer transactions
        {
            $join_column = "user_id";
        }
        

        $pagination =  Transactions::SELECT('transactions.*', 'campaigns.title','u.name as user_name','u.image as user_image','u.id as transaction_user_id')
                                    ->where('transactions.user_id', $user->id)
                                    ->join('users', 'users.id', '=', 'transactions.user_id')
                                    ->leftJoin('campaigns', 'campaigns.id', '=', 'transactions.campaign_id')
                                    ->leftJoin('offers', 'offers.id', '=', 'transactions.offer_id')
                                    ->leftJoin('users as u', 'offers.'.$join_column, '=', 'u.id')
                                    ->orderBy('transactions.id','DESC')
                                    //->get();
                                    ->paginate($this->getPagination());
        $transations['balance'] = $user->balance;      
        // $transations['transactions'] = $this->transactionstransformer->transformCollection($pagination);   
        // return $this->sendResponse($transations,trans('lang.read succefully'),200);


        if($user->account_type == 1) {
            $this->transactionstransformer->setInfluncerFlag(true);           
        }
        $transations['transactions'] =  $this->transactionstransformer->transformCollection(collect($pagination->items()));
        // foreach ($notifications as $key => $value) {
        //     $notifications_array[] = $value->id;
        // }
        // if(!empty($notifications_array))
        // {
        //     $notifications_array = Notification::where('user_id' , $user->id)->whereIn('id', $notifications_array)->update(['is_seen' => '1']);
        // }
        //return $this->sendResponse($pagination,trans('lang.read succefully'),200);
        return $this->respondWithPagination($pagination, ['data' => $transations ]);
    }


    function details(Request $request,$id)
    {

        $user =  $this->getAuthenticatedUser();
        if($user->account_type == 0) // user transactions 
        {
            $join_column = "influncer_id"; 
        }
        else // influencer transactions
        {
            $join_column = "user_id";
            $this->transactionstransformer->setInfluncerFlag(true);           
        }
        

        $validator = Validator::make( ['id' =>  $request->id ], [
            'id'    => 'required|exists:transactions,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('paramters failed validation');
        }
        $data =  Transactions::SELECT('transactions.*', 'campaigns.title','u.name as user_name','u.image as user_image','u.id as transaction_user_id')
                                    ->where('transactions.id', $request->id)
                                    ->where('transactions.user_id', $user->id)
                                    ->join('users', 'users.id', '=', 'transactions.user_id')
                                    ->leftJoin('campaigns', 'campaigns.id', '=', 'transactions.campaign_id')
                                    ->leftJoin('offers', 'offers.id', '=', 'transactions.offer_id')
                                    ->leftJoin('users as u', 'offers.'.$join_column, '=', 'u.id')->first();
        if ( !empty ( $data ) ) {
            
            $transaction = $this->transactionstransformer->transform($data);
            return $this->sendResponse($transaction,trans('lang.read succefully'),200);
        }else{
            return $this->setStatusCode(422)->respondWithError('paramters failed validation');
        }                                
        
    }






    public function store( Request $request )
    {
        $user =  $this->getAuthenticatedUser();
        if($user->account_type != 0) return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
        // $validator = Validator::make( $request->all(), [
        //     'transaction_amount'            => 'required|numeric',
        //     'transaction_bank_name'         =>  'required',
        //     'transaction_account_name'      =>  'required',
        //     'transaction_account_number'    =>  'required',
        //     'transaction_account_IBAN'      =>  'required',
        //     'transaction_number'            =>  'required',
        //     'transaction_date'              =>  'required',
        //     'image'                         => 'required'
        // ]);

        $rules = [
            'transaction_amount'            => 'required|numeric'
        ];

        if($request->fort_id)
        {
            $rules = [
                'transaction_amount'            => 'required|numeric',
                'sdk_token'                     => 'nullable',
                'merchant_reference'            => 'nullable',
                'card_holder_name'              => 'nullable',
                'card_number'                   => 'nullable',
                'authorization_code'            => 'nullable',
                'response_code'                 => 'nullable',
                'payment_option'                => 'nullable',
                'fort_id'                       => 'nullable',
                'amount'                        => 'nullable',
                'eci'                           => 'nullable',
                'customer_ip'                   => 'nullable',
                'command'                       => 'nullable',
            ];
            
        }
        else
        {
            $rules = [
                'transaction_amount'            => 'required|numeric',
                'transaction_bank_name'         => 'required',
                'transaction_account_name'      => 'required',
                'transaction_account_number'    => 'required',
                'transaction_account_IBAN'      => 'required',
                'transaction_number'            => 'required',
                'transaction_date'              => 'required',
                'image'                         => 'required',
            ];
        }


        $validator = Validator::make(Input::all(), $rules);
        

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }

        //$bankaccount = BankAccounts::where('user_id', $user->id)->delete();
        // if($bankaccount)
        // {
        //     $bankaccount->delete();
        // }


        $transations = new Transactions;
        $transations->user_id = $user->id;
        if($request->fort_id) // payfort online payment
        {
            $transations->card_holder_name     = $request->card_holder_name;
            $transations->transaction_account_name     = $request->card_holder_name;
            $transations->sdk_token     = $request->sdk_token;
            $transations->merchant_reference     = $request->merchant_reference;
            $transations->card_number     = $request->card_number;
            //$transations->transaction_account_number     = $request->transaction_account_number;
            $transations->transaction_account_number     = $request->fort_id;
            $transations->authorization_code     = $request->authorization_code;
            $transations->response_code     = $request->response_code;
            $transations->payment_option     = $request->payment_option;
            $transations->fort_id     = $request->fort_id;
            $transations->eci     = $request->eci;
            $transations->customer_ip     = $request->customer_ip;
            $transations->command     = $request->command;
            $transations->status       = "1";

        }
        else 
        {
            $transations->transaction_bank_name     = $request->transaction_bank_name;
            $transations->transaction_account_name            = $request->transaction_account_name;
            $transations->transaction_account_number     = $request->transaction_account_number;
            $transations->transaction_account_IBAN     = $request->transaction_account_IBAN;
            $transations->transaction_number     = $request->transaction_number;
            $transations->transaction_date = Carbon::parse($request->transaction_date);
            $transations->transaction_amount     = $request->transaction_amount;
            $transations->image     = $request->image;
            $transations->status       = 0;
        }
        
        $transations->direction    = 0;
        $transations->type         = 0;
        $transations->campaign_id  = 0;
        $transations->offer_id     = 0;
        $transations->amount       = $request->transaction_amount;


        $transations->save();


        if($request->fort_id) // payfort online payment
        {
            $userData = User::find($user->id);
            $user->balance = $userData->balance + $request->transaction_amount;
            $user->save();
        }

        return $this->respondWithSuccess(trans('api_msgs.created'));

    }







    const PaymentOptions = [
        "UserId"=> "8ac7a4c968cca59c0168e8d690593326",
        "Password"=> "Gzexk2PShG",
        "EntityID"=> "8ac7a4c968cca59c0168e8d70a23332a",
        "PaymentMethods"=> ["VISA", "MASTER"],
        "PaymentType"=> "DB",
        "Currency"=> "SAR",
        "Link"=>"https://test.oppwa.com/",

        "testMode"=> "EXTERNAL",
        "merchantTransactionId" => "", //your unique ID in your database
        "customerEmail" => "", //the user email
        "redirectLink" => "/api/v1/en/user/transaction/notifyDB",
    ];

//Payment with hyperpay APIs
    public function getCheckoutId(Request $request){
        $user =  $this->getAuthenticatedUser();
        if($user->account_type != 0) return $this->setStatusCode(401)->respondWithError(trans('api_msgs.not_authorized'));
        $rules = [ 'amount' => 'required|string' ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) return $this->setStatusCode(403)->respondWithError($validator->messages());
        
        $amount = $request->input("amount","00.00");
        $responseData = $this->sendTransactionPreparationRequest($amount);
        return response($responseData, 200)->header('Content-Type', 'application/json');
    }

    private function sendTransactionPreparationRequest($amount) {
        $url = Self::PaymentOptions["Link"]."v1/checkouts";
        $data = "authentication.userId=".Self::PaymentOptions["UserId"] .
                    "&authentication.password=".Self::PaymentOptions["Password"] .
                    "&authentication.entityId=".Self::PaymentOptions["EntityID"] .
                    "&amount=".$amount.
                    "&currency=".Self::PaymentOptions["Currency"] .
                    "&paymentType=".Self::PaymentOptions["PaymentType"] .
                    "&testMode=".Self::PaymentOptions["testMode"] .
                    "&merchantTransactionId=".Self::PaymentOptions["merchantTransactionId"] .
                    "&customer.email=".Self::PaymentOptions["customerEmail"] .
                    "&notificationUrl=".env("APP_URL").Self::PaymentOptions["redirectLink"];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            dd("error happened: ", curl_error($ch));
            return curl_error($ch);
        }
        curl_close($ch);
        $responseData = json_decode($responseData, true);
        $responseData["checkoutID"] =$responseData["id"];
        return $responseData;
    }


    public function notifyDB(Request $request){
        $rules = [
            "resourcePath"=>"required|string",
            "user_id"=>"required|integer",
            "campaign_id"=>"integer",
            "offer_id"=>"integer"
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) return $this->setStatusCode(403)->respondWithError($validator->messages());
        
        $user = User::find($request->user_id);
        if($user->account_type != 0) return $this->setStatusCode(401)->respondWithError(trans('api_msgs.not_authorized'));

        $resourcePath = str_replace("%2","/",$request->resourcePath);
        // $user =  $this->getAuthenticatedUser();
        if(true && env("APP_ENV")=="local") $responseData = $this->apiResponse;
        else{
            $url = Self::PaymentOptions["Link"].$resourcePath;
            $url .= "?authentication.userId=".Self::PaymentOptions["UserId"];
            $url .= "&authentication.password=".Self::PaymentOptions["Password"];
            $url .= "&authentication.entityId=".Self::PaymentOptions["EntityID"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
        }
        $responseData = json_decode($responseData, true);
        
        if( isset($responseData["id"]) 
                && isset($responseData["result"]["code"]) 
                && $responseData["result"]["code"] == "000.100.112" ){
            return $this->updateTheDB($responseData, [
                "user" => $user,
                "campaign_id" => $request->input("campaign_id",0),
                "offer_id" => $request->input("offer_id",0)
            ]);
        }else return responseHelper::Fail("failedToProceed",["msg"=>"problem with the response, ".$responseData["result"]["description"]."...", "response"=>$responseData]);
    }


    public function getStatus(Request $request){
        $id = $request->input("id","undefined id");
        $url = Self::PaymentOptions["Link"]."v1/checkouts/".$id."/payment";
        $url .= "?authentication.userId=".Self::PaymentOptions["UserId"];
        $url .= "&authentication.password=".Self::PaymentOptions["Password"];
        $url .= "&authentication.entityId=".Self::PaymentOptions["EntityID"];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $responseData = json_decode($responseData, true);
        return $responseData;
    }


    private function updateTheDB($responseData, $session_params){
        // dd($responseData, $session_params);
        $user = $session_params["user"];

        $transaction_response = [
            "id" => $responseData["id"],
            "card_holder_name" => $responseData["card"]["holder"],
            "transaction_amount" => $responseData["amount"],
            "sdk_token"=> $responseData["id"],
            "merchant_reference"=> "", //$responseData["customParameters"]["SHOPPER_EndToEndIdentity"], 
            "card_number"=> $responseData["card"]["bin"]."******".$responseData["card"]["last4Digits"],  //512345******2346
            "authorization_code" => "0",//$responseData["resultDetails"]["AuthorizeId"],
            "response_code" => $responseData["result"]["code"],
            "payment_option" => $responseData["paymentBrand"],

            "eci" => $responseData["ndc"],
            "customer_ip" => $responseData["customer"]["ip"],
            "command" => "PURCHASE"
        ];

        $transations = new Transactions;
        $transations->user_id = $user->id;

        if($session_params["campaign_id"]==0 && $session_params["offer_id"]==0){    //if rechargin
            $transations->card_holder_name     = $transaction_response["card_holder_name"];
            $transations->transaction_account_name     = $transaction_response["card_holder_name"];
            $transations->sdk_token     = $transaction_response["sdk_token"];
            $transations->merchant_reference     = $transaction_response["merchant_reference"];
            $transations->card_number     = $transaction_response["card_number"];

            $transations->transaction_account_number     = $transaction_response["id"];
            $transations->authorization_code     = $transaction_response["authorization_code"];
            $transations->response_code     = $transaction_response["response_code"];
            $transations->payment_option     = $transaction_response["payment_option"];
            $transations->fort_id     = $transaction_response["id"];
            $transations->eci     = $transaction_response["eci"];
            $transations->customer_ip     = $transaction_response["customer_ip"];
            $transations->command     = $transaction_response["command"];
            $transations->status       = "1";

            $transations->direction    = 0;
            $transations->type         = 0;
            $transations->campaign_id  = $session_params["campaign_id"];
            $transations->offer_id     = $session_params["offer_id"];
            $transations->amount       = $transaction_response["transaction_amount"];
            $transaction = $transations->save();

            $user->balance = $user->balance + $transaction_response["transaction_amount"];
            $user = $user->save();
            return responseHelper::Success("success",["message"=>"success in transaction in wallet transaction"]);
        }
        else{                                                              //if paying for a campaign
            // $offer = Offer::find($transations->offer_id);
            // $offer->status = 4;
            // $offer->save();

            $offer = Offer::where([['id', $session_params["offer_id"]], ['status', "1"]])->get()->first();
            if(!$offer) return responseHelper::Fail("resourceNotFound",["message"=>"offer is not found or not approved"]);

            $settings = Setting::first();
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
            if($total_offer_value > (int)$user->balance && !isset($transaction_response["id"])){ die("offer not payed"); }
            
            $offer->status = "3";
            $offer->save();
            ///////////////////////////////////// payment success or redirect /////////////////////////////////////

            $campaign = Campaign::where('id', $session_params["campaign_id"])->get()->first();

            if($offer->cost) $transations->amount = $offer->cost;
            else $transations->amount     = 0;
            $transations->direction = 1;
            $transations->type     = 1;
            $transations->status     = 0;
            $transations->campaign_id     = $offer->campaign_id;
            $transations->offer_id     = $offer->id;

            // if($request->amount) $transations->transaction_amount     = $request->amount;
            // else $transations->transaction_amount     = $total_offer_value;
            $transations->transaction_amount     = $transaction_response["transaction_amount"];


            $transations->card_holder_name     = $transaction_response["card_holder_name"];
            $transations->transaction_account_name     = $transaction_response["card_holder_name"];
            $transations->sdk_token     = $transaction_response["sdk_token"];
            $transations->merchant_reference     = $transaction_response["merchant_reference"];
            $transations->card_number     = $transaction_response["card_number"];

            $transations->transaction_account_number     = $transaction_response["id"];
            $transations->authorization_code     = $transaction_response["authorization_code"];
            $transations->response_code     = $transaction_response["response_code"];
            $transations->payment_option     = $transaction_response["payment_option"];
            $transations->fort_id     = $transaction_response["id"];
            $transations->eci     = $transaction_response["eci"];
            $transations->customer_ip     = $transaction_response["customer_ip"];
            $transations->command     = $transaction_response["command"];
            $transations->status       = "1";

            $transations->save();

            if(($user->balance + $transaction_response["transaction_amount"]) < $total_offer_value){
                $user->balance = $user->balance + $transaction_response["transaction_amount"];
                $user->save();
                return responseHelper::Success("success",["message"=>"the payment succeeded but the amount isn't enough"]);
            }else{
                $user->balance = ($user->balance + $transaction_response["transaction_amount"]) - $total_offer_value;
                $user->save();
            }
            
            $transaction_response["message"] = "success in transaction in offer payment";
            return responseHelper::Success("success", $transaction_response);
        }
        // dd($transations, $userData);
    }








    public $apiResponse = '{
"id": "8ac7a4a069533d8601695351a98f17ff",
"paymentType": "DB",
"paymentBrand": "VISA",
"amount": "5000.00",
"currency": "SAR",
"descriptor": "4229.2796.8916 Smaat",
"result": {
"code": "000.100.112",
"description": "Request successfully processed in \'Merchant in Connector Test Mode\'"
},
"resultDetails": {
"CscResultCode": "M",
"ConnectorTxID1": "1100042026",
"connectorId": "1100042026",
"VerStatus": "Y",
"BatchNo": "20190306",
"AuthorizeId": "006522",
"AvsResultCode": "Unsupported"
},
"card": {
"bin": "420000",
"last4Digits": "0000",
"holder": "ggg",
"expiryMonth": "12",
"expiryYear": "2020"
},
"customer": {
"ip": "41.44.9.232",
"ipCountry": "EG"
},
"customParameters": {
"SHOPPER_EndToEndIdentity": "46b89b12def462b88a2e6e0030d6c47af200d23a012d663dfe3e86258e5b7548",
"CTPE_DESCRIPTOR_TEMPLATE": ""
},
"risk": {
"score": "100"
},
"buildNumber": "d66d3fc05bf113625470780c5318c89ffbcbf88e@2019-03-06 11:53:17 +0000",
"timestamp": "2019-03-06 14:04:35+0000",
"ndc": "E88076796659FBA4394ECB794CD2E8E2.uat01-vm-tx04"
}';




}
