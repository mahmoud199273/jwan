<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as Controller;
use App\Transformers\ComplaintsTransformer;
use App\User;
use App\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ComplaintsController extends Controller
{

    protected $compliantsTransformer;

    function __construct(Request $request, ComplaintsTransformer $compliantsTransformer){
        App::setlocale($request->lang);
    	$this->middleware('jwt.auth')->only(['store']);
        $this->compliantsTransformer   = $compliantsTransformer;
    }


    public function store( Request $request )
    {
        $user =  $this->getAuthenticatedUser();

        $validator = Validator::make( $request->all(), [

            'title' => 'required',

            'body'  => 'required'

        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        $complaint = new Complaint;


        $complaint->title            = $request->title;

        $complaint->body            = $request->body;

        $complaint->user_id          = $user->id;

        $complaint->save();

        return $this->respondWithSuccess(trans('api_msgs.created'));

    }


    

}
