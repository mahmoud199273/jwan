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

class TransactionsController extends Controller
{

    protected $transactionstransformer;

    function __construct(Request $request, TransactionsTransformer $transactionstransformer){
        App::setlocale($request->lang);
    	   $this->middleware('jwt.auth');
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
        $pagination =  Transactions::where('transactions.user_id', $user->id)
                                    ->join('users', 'users.id', '=', 'transactions.user_id')
                                    ->leftJoin('campaigns', 'campaigns.id', '=', 'transactions.id')
                                    ->leftJoin('offers', 'offers.id', '=', 'transactions.id')
                    ->orderBy('transactions.id','DESC')
                    ->paginate($this->getPagination());
        $transations =  $pagination->items();
        // foreach ($notifications as $key => $value) {
        //     $notifications_array[] = $value->id;
        // }
        // if(!empty($notifications_array))
        // {
        //     $notifications_array = Notification::where('user_id' , $user->id)->whereIn('id', $notifications_array)->update(['is_seen' => '1']);
        // }
        return $this->respondWithPagination($pagination, ['data' => $transations ]);
    }






    public function store( Request $request )
    {
        $user =  $this->getAuthenticatedUser();
        $validator = Validator::make( $request->all(), [
            'transaction_amount'    => 'required|numeric',
            'transaction_bank_name'   =>  'required',
            'transaction_account_name'   =>  'required',
            'transaction_account_number'   =>  'required',
            'transaction_account_IBAN'   =>  'required',
            'transaction_number'   =>  'required',
            'transaction_date'   =>  'required',
            'image'             => 'required'
        ]);


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
        $transations->transaction_bank_name     = $request->transaction_bank_name;
        $transations->transaction_account_name            = $request->transaction_account_name;
        $transations->transaction_account_number     = $request->transaction_account_number;
        $transations->transaction_account_IBAN     = $request->transaction_account_IBAN;
        $transations->transaction_number     = $request->transaction_number;
        // $transations->transaction_date     = $request->transaction_date;
        $transations->transaction_date = Carbon::parse($request->transaction_date);
        $transations->transaction_amount     = $request->transaction_amount;
        $transations->image     = $request->image;

        $transations->direction = 0;
        $transations->type     = 0;
        $transations->status     = 0;
        $transations->campaign_id     = 0;
        $transations->offer_id     = 0;
        $transations->amount     = $request->transaction_amount;


        $transations->save();

        return $this->respondWithSuccess(trans('api_msgs.created'));

    }

}
