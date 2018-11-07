<?php


namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Transformers\BanksTransformer;
use App\Banks;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class BanksController extends BaseController
{

    protected $banksstransformer;


    function __construct(Request $request, BanksTransformer $banksstransformer ){
        App::setlocale($request->lang);
        // $this->middleware('jwt.auth');
        $this->banksstransformer = $banksstransformer;
    }

    public function index()
    {
        # code...
        $banks = $this->banksstransformer->transformCollection(Banks::all());
        return $this->sendResponse($banks,'Banks list read succesfully',200);
    }



}
