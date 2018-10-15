<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as Controller;
use App\Transformers\OffersTransformer;
use App\User;
use App\Offer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OffersController extends Controller
{

    protected $offersTransformer;

    function __construct(Request $request, OffersTransformer $offersTransformer){
        App::setlocale($request->lang);
    	$this->middleware('jwt.auth');
        $this->offersTransformer   = $offersTransformer;
    }







     public function allOffers( Request $request,User $user )
     {
         $user =  $this->getAuthenticatedUser();




         $offers = Offer::where('influncer_id',$user->id)->get();

        // dd($offers);





         return $this->sendResponse( $this->offersTransformer->transformCollection($offers),'read succefully',200);   
     }










    public function show( Request $request , $id )
    {

        $validator = Validator::make( ['id' =>  $request->id ], [
            'id'    => 'required|exists:offers,id',
        ]);
        return $validator->fails() ? $this->setStatusCode(422)->respondWithError('parameters faild validation') :
                                        $this->sendResponse( $this->offersTransformer->transform(Offer::find($request->id)),'read succefully',200);

    }







    public function index(Request $request)
    {
    # code...
        $user =  $this->getAuthenticatedUser();

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

        return $this->sendResponse($offers, 'campaigns read succesfully',200);
    }






    public function store( Request $request )
    {
        $user =  $this->getAuthenticatedUser();

        $validator = Validator::make( $request->all(), [

            'campaign_id'      =>'required',

            'cost'             =>'required',

            'description'      =>'required'    



        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }

        $offer = new Offer;

        $offer->campaign_id     = $request->campaign_id;

        $offer->cost            = $request->cost;

        $offer->description     = $request->description;
        
        $offer->influncer_id     = $user->id;

        $offer->save();


        return $this->respondWithSuccess(trans('api_msgs.created'));

    }


         public function offerStatus(Request $request)

        {
            $user =  $this->getAuthenticatedUser();

            $validator = Validator::make( $request->all(), [
            'id'                   => 'required|exists:offers,id',
            'status'                     => 'required'

            ]);

            if ($validator->fails()) {
                return $this->setStatusCode(422)->respondWithError($validator->messages());
                return $this->setStatusCode(422)->respondWithError('parameters faild validation');
            }

            $offer = Offer::find($request->id);


            $offer->status         = $request->status;

            $offer->user_id        = $user->id;

            $offer->save();

            return $this->respondWithSuccess(trans('api_msgs.set status successfully'));

            
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



}
