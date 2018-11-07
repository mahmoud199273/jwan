<?php


namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Transformers\AppBanksTransformer;
use App\AppBankAccounts;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class AppBankController extends BaseController
{

    protected $appbankstransformer;


    function __construct(Request $request, AppBanksTransformer $appbankstransformer ){
        App::setlocale($request->lang);
        // $this->middleware('jwt.auth');
        $this->appbankstransformer = $appbankstransformer;
    }

    public function index()
    {
        # code...
        $banks = $this->appbankstransformer->transformCollection(AppBankAccounts::all());
        return $this->sendResponse($banks,'App Banks read succesfully',200);
    }



}
