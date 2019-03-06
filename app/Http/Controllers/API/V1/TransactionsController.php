<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as Controller;
// use App\Transformers\BankAccountsTransformer;
use App\Transformers\TransactionsTransformer;
use App\User;
use App\BankAccounts;
use App\Transactions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;


use Illuminate\Support\Facades\Log;


class TransactionsController extends Controller
{

    protected $transactionstransformer;

    function __construct(Request $request, TransactionsTransformer $transactionstransformer){
        App::setlocale($request->lang);
    	$this->middleware('jwt.auth', ["except"=>["notifyDB"]]);
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
        if($user->account_type != 0)
        {
            return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
        }
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
        // dd(
        //     $request->input("id","id undefined"), 
        //     $request->input("resourcePath","resourcePath undefined"),
        //     Self::PaymentOptions["Link"].$request->input("resourcePath")
        // );
        $url = Self::PaymentOptions["Link"].$request->input("resourcePath");
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
        // $this->updateTheDB();
        return $responseData;
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


    private function updateTheDB(){
        $user =  $this->getAuthenticatedUser();

        $transations = new Transactions;
        $transations->user_id = $user->id;


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
    }



}
