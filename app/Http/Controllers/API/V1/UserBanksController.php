<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as Controller;
use App\Transformers\BankAccountsTransformer;
use App\User;
use App\BankAccounts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;

class UserBanksController extends Controller
{

    protected $bankaccounttransformer;

    function __construct(Request $request, BankAccountsTransformer $bankaccounttransformer){
        App::setlocale($request->lang);
    	   $this->middleware('jwt.auth');
        $this->bankaccounttransformer   = $bankaccounttransformer;
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

        // if($user->account_type == '0'){
        //     return $this->setStatusCode(422)->respondWithError(trans('api_msgs.you do not have the right to be here'));
        // }

            $data = BankAccounts::where([['user_id' ,$user->id]])->get();
            $bankaccounts = $this->bankaccounttransformer->transformCollection($data);

        return $this->sendResponse($bankaccounts, trans('lang.bank account read succesfully'),200);
    }






    public function store( Request $request )
    {
        $user =  $this->getAuthenticatedUser();

        // if($user->account_type == '0'){
        //     return $this->setStatusCode(422)->respondWithError(trans('api_msgs.you do not have the right to be here'));
        // }

        $validator = Validator::make( $request->all(), [

            'bank_id'      =>'required|exists:banks,id',
            'account_name'             =>'required',
            'IBAN'      =>'required',
            'note'      =>'nullable',
            'account_number'      =>'required',
        ]);


        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }

        $bankaccount = BankAccounts::where('user_id', $user->id)->get()->first();
        if($bankaccount)
        {
            $flight->trashed();
        }


        $bankaccount_new = new BankAccounts;
        $bankaccount_new->user_id = $user->id;
        $bankaccount_new->bank_id     = $request->bank_id;
        $bankaccount_new->account_name            = $request->account_name;
        $bankaccount_new->IBAN     = $request->IBAN;
        $bankaccount_new->note     = $request->note;
        $bankaccount_new->account_number     = $request->account_number;
        $offer->save();

        return $this->respondWithSuccess(trans('api_msgs.created'));

    }

}
