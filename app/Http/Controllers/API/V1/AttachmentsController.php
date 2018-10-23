<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as Controller;
use App\Transformers\AttachmentsTransformer;
use App\User;
use App\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AttachmentsController extends Controller
{

    protected $attachmentsTransformer;

    function __construct(Request $request, AttachmentsTransformer $attachmentsTransformer){
        App::setlocale($request->lang);
        $this->middleware('jwt.auth')->only(['store']);
        $this->attachmentsTransformer   = $attachmentsTransformer;
    }





    public function store( Request $request )
    {
        $user =  $this->getAuthenticatedUser();

        $validator = Validator::make( $request->all(), [

            'file' => 'required',

            'file_type'  => 'required'

        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        $attachment = new Attachment;


        $attachment->title                = $request->title;

        $attachment->body                 = $request->body;

        $attachment->campaign_id          = $request->campaign_id;

        $attachment->save();

        return $this->respondWithSuccess(trans('api_msgs.created'));

    }




}
