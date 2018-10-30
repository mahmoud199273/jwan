<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as Controller;
use App\Transformers\OffersTransformer;
use App\User;
use App\Offer;
use App\Chat;
use App\Campaign;
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

    public function influncerHasOffer($influncer_id,$campaign_id)
    {
         return Offer::where([
            ['influncer_id',$influncer_id],
            ['campaign_id',$campaign_id]
            ])->first() ? true : false;
    }







     public function allOffers( Request $request,User $user )
     {
         $influncer =  $this->getAuthenticatedUser();
         $offers = Offer::where('influncer_id',$influncer->id)->get();
        // dd($offers);
         return $this->sendResponse( $this->offersTransformer->transformCollection($offers),trans('lang.read succefully'),200);
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
            $offer->status = "1";
            $offer->save();

            //////////////////// new push /////////////////////////////////////
            return $this->respondWithSuccess(trans('api_msgs.updated'));
        }



                public function reject(Request $request)
                {
                    $user =  $this->getAuthenticatedUser();
                    // security check
                    $offer = Offer::where([['id',$request->id], ['status', "0"]])->get()->first();
                    if(!$offer){
                        return $this->setStatusCode(422)->respondWithError(trans('api_msgs.offer is not found or approved before'));
                    }
                    $offer->status = "2";
                    $offer->save();

                    //////////////////// new push /////////////////////////////////////
                    return $this->respondWithSuccess(trans('api_msgs.updated'));
                }

        public function pay(Request $request)
        {
            $user =  $this->getAuthenticatedUser();
            // security check
            $offer = Offer::where([['id',$request->id], ['status', "1"]])->get()->first();
            if(!$offer){
                return $this->setStatusCode(422)->respondWithError(trans('api_msgs.offer is not found or not approved'));
            }
            $offer->status = "3";
            $offer->save();
            ///////////////////////////////////// payment success or redirect /////////////////////////////////////
            //////////////////// new push /////////////////////////////////////
            return $this->respondWithSuccess(trans('api_msgs.updated'));
        }





                public function inprogress(Request $request)
                {
                    $user =  $this->getAuthenticatedUser();
                    // security check should be influncer and owner of request
                    $offer = Offer::where([['id',$request->id], ['status', "3"]])->get()->first();
                    if(!$offer){
                        return $this->setStatusCode(422)->respondWithError(trans('api_msgs.offer is not found or not approved'));
                    }
                    $offer->status = "4";
                    $offer->save();
                    ///////////////////////////////////// payment success or redirect /////////////////////////////////////
                    //////////////////// new push /////////////////////////////////////
                    return $this->respondWithSuccess(trans('api_msgs.updated'));
                }

                public function proof(Request $request)
                {
                    $user =  $this->getAuthenticatedUser();
                    // security check should be influncer and owner of request
                    $offer = Offer::where([['id',$request->id], ['status', "4"]])->get()->first();
                    if(!$offer){
                        return $this->setStatusCode(422)->respondWithError(trans('api_msgs.offer is not found or not being working on'));
                    }
                    $offer->status = "5";
                    $offer->save();
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

            'description'      =>'required'
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
        $offer->user_id = $campaign->user_id;
        $offer->influncer_id     = $influncer->id;
        $offer->cost            = $request->cost;
        $offer->description     = $request->description;
        $offer->save();

        //$request->description

        $chat = new Chat;
        $chat->from_user_id	= $influncer->id;
        $chat->to_user_id = $campaign->user_id;
        $chat->offer_id = $offer->id;
        $chat->campaign_id = $request->campaign_id;
        $chat->content = $request->description;
        $chat->type = 1;
        $chat->save();

        //////////////////////////////////// new push /////////////////////////////////////////////
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
       ]);

       // if($this->influncerHasOffer($influncer->id,$request->campaign_id)){
       //     return $this->setStatusCode(422)->respondWithError('Already offerd before');
       // }

       if ($validator->fails()) {
           return $this->setStatusCode(422)->respondWithError($validator->messages());
           return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
       }



       $offer = Offer::find($request->id);
       $offer->cost            = $request->cost;
       if(strlen($request->description)!=0)
       {
         $offer->description     = $request->description;
       }
       $offer->save();

       //$request->description
       $campaign = Campaign::where('id', $request->campaign_id)->get();

       if(strlen($request->description)!=0)
       {
         $chat = new Chat;
         $chat->from_user_id	= $influncer->id;
         $chat->to_user_id = $campaign->user_id;
         $chat->offer_id = $offer->id;
         $chat->campaign_id = $campaign->id;
         $chat->content = $request->description;
         $chat->type = 1;
         $chat->save();
       }



      //////////////////////////////////// new push //////////////////////////////////////////////////////

       return $this->respondWithSuccess(trans('api_msgs.created'));


       ///////////////////// zzzzzzzz //////

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
