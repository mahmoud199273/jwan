<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as Controller;
use App\Transformers\CampaignsTransformer;
use App\User;
use App\Campaign;
use App\Attachment;
use App\CampaignArea;
use App\CampaignCategory;
use App\CampaignCountry;
use App\InfluncerCampaign;
use App\UserCategory;
use App\UserCountry;
use App\Setting;
use App\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CampignsController extends Controller
{

    protected $campaignsTransformer;

    function __construct(Request $request, CampaignsTransformer $campaignsTransformer){
        App::setlocale($request->lang);
    	$this->middleware('jwt.auth');
        $this->campaignsTransformer   = $campaignsTransformer;
    }



    public function index( Request $request )
    {
        $influncer =  $this->getAuthenticatedUser();

        $campaign_ids = InfluncerCampaign::where('influncer_id',$influncer->id)->pluck('campaign_id')->toArray();
         //dd($campaign_ids);
 
        //$orderBy = 'created_at';
        $orderBy = 'updated_at';
        $influncer_categories = UserCategory::where('user_id',$influncer->id)->pluck('categories_id')->toArray();
 
 
 
        $influncer_countries = UserCountry::where('user_id',$influncer->id)->pluck('country_id')->toArray();
 
 
        //dd($influncer_categories);
 
            $campaigns = DB::table('campaigns')
 
 
 
            ->join('campaign_countries', 'campaigns.id', '=', 'campaign_countries.campaign_id')
 
            ->join('campaign_categories', 'campaigns.id', '=', 'campaign_categories.campaign_id');
 
            if($influncer_categories){
                $campaigns->whereIn('campaign_categories.category_id',$influncer_categories);
 
            }
 
            if($influncer_countries){
                $campaigns->whereIn('campaign_countries.country_id',$influncer_countries);
 
            }
 
 
            $campaigns->select('campaigns.*');
 
 
            if ($campaign_ids) {
                $campaigns->whereNotIn('campaigns.id',$campaign_ids);
            }
            $campaigns->where('campaigns.status',1)
            ->groupBy('campaigns.id')
 
 
 
 
             ->orderBy($orderBy,'DESC');
 
 
             $result = $campaigns->get();
            //dd($campaigns);
 
        return $this->sendResponse( $this->campaignsTransformer->transformCollection($result),trans('lang.read succefully'),200);
    }









    /* public function index( Request $request )
     {
         $user =  $this->getAuthenticatedUser();

         $campaign_ids = InfluncerCampaign::where('user_id',$user->id)->pluck('campaign_id')->toArray();
         //dd($campaign_ids);

        /* $campaigns = Campaign::where([
            ['id','<>',$campaign_ids]
            ,['status','1']
            ])->get();*/

         /* $campaigns = Campaign::where(
            'status','1'
            )->get();
         dd($campaigns);

          $data = Campaign::where('status','1')->whereNotIn('id',$campaign_ids)->get();
          //dd($data);

         return $this->sendResponse( $this->campaignsTransformer->transformCollection($data),'read succefully',200);
     }*/










    public function show( Request $request , $id )
    {
        $validator = Validator::make( ['id' =>  $request->id ], [
            'id'    => 'required|exists:services,id',
        ]);
        
        return $validator->fails() ? $this->setStatusCode(422)->respondWithError('parameters faild validation') :
                                        $this->sendResponse( $this->campaignsTransformer->transform(Campaign::find($request->id)),
                                            trans('lang.read succefully'),200);

    }

    public function allCampaigns(Request $request)
    {
    # code...
        if($request->id){
            $user =  User::find($request->id);
        }
        else
        {
            $user =  $this->getAuthenticatedUser();
            $this->campaignsTransformer->setFlag(true);
        }
        if ( $request->limit ) {
                $this->setPagination($request->limit);
            }

        //$data = Campaign::where('user_id' ,$user->id)->get();
        $pagination = Campaign::where('user_id' ,$user->id)->orderBy('updated_at','DESC');
        if($request->id) 
        {
            $pagination->where([['status', '!=', '0'],['status', '!=', '8'],['status', '!=', '9'],['status', '!=', '4'],['status', '!=', '5']]);
        }
        else
        {
            $pagination->where([['status', '!=', '8'],['status', '!=', '4']]);
        }
        $pagination = $pagination->paginate($this->getPagination());
        
        $campaigns = $this->campaignsTransformer->transformCollection(collect($pagination->items()));
        //return $this->sendResponse($campaigns, trans('lang.campaigns read succesfully'),200);
        return $this->respondWithPagination($pagination, ['data' => $campaigns ]);    
    }




    public function store( Request $request )
    {
        $user =  $this->getAuthenticatedUser();

        if($user->account_type == '1'){
             return $this->setStatusCode(422)->respondWithError(trans('api_msgs.you do not have the rigtt to be here'));

        }

        $validator = Validator::make( $request->all(), [

            'title'             => 'required',


            'facebook'          => 'required',

            'twitter'           => 'required',

            'snapchat'          => 'required',

            'youtube'           => 'required',

            'instgrame'         => 'required',

            'male'              => 'required',

            'female'            => 'required',

            'general'           => 'required',

            'description'       => 'required',

            'scenario'          => 'required',

            'maximum_rate'      => 'required',

            'files_arr'         => 'nullable',

            'categories_id'     => 'required',

            'countries_id'    => 'required',

            'areas_id'      => 'required'



        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.invalid_data'));
        }

        $campaign = new Campaign;


        $campaign->title            = $request->title;

        $campaign->facebook            = $request->facebook;

        $campaign->twitter            = $request->twitter;

        $campaign->snapchat            = $request->snapchat;

        $campaign->youtube            = $request->youtube;

        $campaign->instgrame            = $request->instgrame;

        $campaign->male            = $request->male;

        $campaign->female            = $request->female;

        $campaign->general            = $request->general;

        $campaign->description            = $request->description;

        $campaign->scenario            = $request->scenario;

        $campaign->maximum_rate            = $request->maximum_rate;

        $campaign->created_at            = Carbon::now()->addHours(3);

        //$campaign->updated_date            = $request->updated_date;

        //$campaign->status            = $request->status;

        $campaign->user_id          = $user->id;

        $campaign->save();

        if(!$request->files_arr){
            Attachment::create([

                'campaign_id'       => $campaign->id,

                'file'              => '/public/assets/images/campaign/campaign.png'
            ]);


        }else{

        $files  =$request->files_arr;

            foreach ($files  as $file) {
                //dd($file['file']);
                Attachment::create([

                'campaign_id'       => $campaign->id,

                'file'              => $file['file']

                //'file_type'          => $file['type']



                      ]);
            }
        }

             $categories_id  =$request->categories_id;

            foreach ($categories_id  as $id) {
                CampaignCategory::create([

                'campaign_id'       => $campaign->id,

                'category_id' => $id


                      ]);
            }
            $countries_id  =$request->countries_id;

            foreach ($countries_id  as $id) {
                CampaignCountry::create([

                'campaign_id'       => $campaign->id,

                'country_id' => $id


                      ]);
            }

            $areas_id  =$request->areas_id;

            foreach ($areas_id  as $id) {
                CampaignArea::create([

                'campaign_id'       => $campaign->id,

                'area_id' => $id


                      ]);
            }

            // $player_ids = $this->getUserPlayerIds($to_user_id);
            // Notification::create(['user_id' => $to_user_id,
            //                           'message' => 'A new campaign was added',
            //                           'message_ar' => 'يوجد حملة جديدة',
            //                           'campaign_id' =>  $offer->campaign_id,
            //                           'offer_id'    => 0,
            //                           'type'          =>  20,
            //                           'type_title'  => 'new campaign']);
            //
            //
            // sendNotification($who,
            //                       'A new campaign was added',
            //                       'يوجد حملة جديدة',
            //                       $player_ids,
            //                       ['campaign_id' =>  (int)$offer->campaign_id,
            //                       'offer_id'    => (int)$offer->id,
            //                       'type'          =>  20,
            //                       'type_title'  => 'new campaign']);

        return $this->respondWithSuccess(trans('api_msgs.created'));

    }


   /* public function update( Request $request )
    {
        $user =  $this->getAuthenticatedUser();

        $validator = Validator::make( $request->all(), [
            'id'                => 'required|exists:campaigns,id',

            'title'             => 'required',

            'facebook'          => 'required',

            'twitter'           => 'required',

            'snapchat'          => 'required',

            'youtube'           => 'required',

            'instgrame'         => 'required',

            'male'              => 'required',

            'female'            => 'required',

            'general'           => 'required',

            'description'       => 'required',

            'scenario'          => 'required',

            'maximum_rate'      => 'required',





        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        $campaign = Campaign::find( $request->id );

        $campaign->title            = $request->title;

        $campaign->facebook         = $request->facebook;

        $campaign->twitter          = $request->twitter;

        $campaign->snapchat         = $request->snapchat;

        $campaign->youtube          = $request->youtube;

        $campaign->instgrame        = $request->instgrame;

        $campaign->male             = $request->male;

        $campaign->female           = $request->female;

        $campaign->general          = $request->general;

        $campaign->description      = $request->description;

        $campaign->scenario         = $request->scenario;

        $campaign->maximum_rate     = $request->maximum_rate;


        $campaign->user_id          = $user->id;

        $campaign->save();


        return $this->respondWithSuccess(trans('api_msgs.updated'));

    }*/

    public function extendCampaign( Request $request )
    {
        $user =  $this->getAuthenticatedUser();

        $settings = Setting::first();


        $amount = $settings->campaign_period;

        $validator = Validator::make( $request->all(), [
            'id'                => 'required|exists:campaigns,id',
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError(trans('parameters faild validation'));
        }




        $campaign = Campaign::find( $request->id );
        if($campaign->user_id!=$user->id)
        {
          return $this->setStatusCode(422)->respondWithError('you dont own it');
        }
        elseif($campaign->is_extened== '1')
        {
            return $this->setStatusCode(422)->respondWithError('Already extended before');
        }
        else {
          $end_date =  Carbon::parse($campaign->end_at);
          $end_date = $end_date->addDays($amount);
          $campaign->is_extened = '1';
          $campaign->end_at = $end_date;

          $campaign->save();


          return $this->respondWithSuccess(trans('api_msgs.extended'));
        }

    }




        public function closeCampaign( Request $request )
        {
            $user =  $this->getAuthenticatedUser();

            $validator = Validator::make( $request->all(), [
                'id'                => 'required|exists:campaigns,id',
            ]);

            if ($validator->fails()) {
                return $this->setStatusCode(422)->respondWithError($validator->messages());
                return $this->setStatusCode(422)->respondWithError(trans('parameters faild validation'));
            }
            else {
              $campaign = Campaign::find( $request->id );
              if($campaign->user_id!=$user->id)
              {
                return $this->setStatusCode(422)->respondWithError('you dont own it');
              }
              else {
                $campaign->status = '5';
                $campaign->save();
                return $this->respondWithSuccess(trans('api_msgs.closed'));
              }
            }

        }



            public function cancelCampaign( Request $request )
            {
                $user =  $this->getAuthenticatedUser();

                $validator = Validator::make( $request->all(), [
                    'id'                => 'required|exists:campaigns,id',
                ]);

                if ($validator->fails()) {
                    return $this->setStatusCode(422)->respondWithError($validator->messages());
                    return $this->setStatusCode(422)->respondWithError(trans('parameters faild validation'));
                }
                else {
                  $campaign = Campaign::find( $request->id );
                  if($campaign->user_id!=$user->id)
                  {
                    return $this->setStatusCode(422)->respondWithError('you dont own it');
                  }
                  else {
                    $campaign->status = '4';
                    $campaign->save();

                    

                    return $this->respondWithSuccess(trans('api_msgs.canceled'));
                  }
                }
            }


/*
0 = new
1 = approved
2 = rejected
3 = finished
4 = canceled
5 = closed
// 3 = in progress
// 4= Pending proof
// 5= Pending payment
// 6= Confirmed
*/


     public function approveCampaign( Request $request )
    {
        $user =  $this->getAuthenticatedUser();
        $validator = Validator::make( $request->all(), [
            'id'                => 'required|exists:campaigns,id'


        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError(trans('parameters faild validation'));
        }

        //$campaigns = DB::table('campaigns')->first();


        $campaign = Campaign::find( $request->id );

        if($campaign->status == '0'){

            $campaign->status = '1';

            $campaign->save();
        }

        return $this->respondWithSuccess(trans('api_msgs.updated'));
    }

    public function isCampaignExist($influncer_id,$campaign_id)
    {
         return InfluncerCampaign::where([
            ['influncer_id',$influncer_id],
            ['campaign_id',$campaign_id]
            ])->first() ? true : false;
    }



         public function status(Request $request)

        {
            $influncer =  $this->getAuthenticatedUser();


           $validator = Validator::make( $request->all(), [
           'campaign_id'                => 'required',
           'status'                     => 'required'

           ]);

           if($this->isCampaignExist($influncer->id,$request->campaign_id) && $request->status != 2){
           return $this->setStatusCode(422)->respondWithError('you have put a status for this campaign before you can change campaign status');
       }

           if ($validator->fails()) {
               return $this->setStatusCode(422)->respondWithError($validator->messages());
               return $this->setStatusCode(422)->respondWithError('parameters faild validation');
           }

           if($request->status == 2)
           {
                influncercampaign::where("campaign_id",$request->campaign_id)->delete();
           }
           else
           {
                $influncercampaign = new InfluncerCampaign;

                $influncercampaign->campaign_id    = $request->campaign_id;

                $influncercampaign->status         = $request->status;

                $influncercampaign->influncer_id        = $influncer->id;

                $influncercampaign->influncer_id        = $influncer->id;


                $influncercampaign->save();
           }
           

           //influncercampaign::find($id)->delete();

           return $this->respondWithSuccess(trans('api_msgs.set status successfully'));


        }


        public function skipped(Request $request)

        {
            $user =  $this->getAuthenticatedUser();

            $skipped = DB::table('influncer_campaigns')
                     ->where([['status', '=', '0'],
                        ['influncer_id',$user->id],
                        ['deleted_at',NULL]
                 ])
                     ->pluck('campaign_id')->toArray();
            //dd($skipped);

            $campaign = DB::table('campaigns')
                     ->whereIn('id',  $skipped)
                     ->orderBy('updated_at','DESC')
                     ->get();

           //dd($campaign);

            //$result =  $this->campaignsTransformer->transformCollection(collect($campaign->items()));

         //return $this->respondWithPagination($campaign,[ 'data' =>  $campaignsTransformer]);

        //return $this->respond( ['data' => $this->campaignsTransformer->transformCollection(Campaign::where('status','1')->get())]);

        //return $this->respond($campaign ,['data' =>  $result]);

         $result = $this->campaignsTransformer->transformCollection($campaign);

        return $this->sendResponse( $result,trans('lang.readed successfully'),200);


        }

        public function favorite(Request $request)

        {
            $user =  $this->getAuthenticatedUser();

            $favorite = DB::table('influncer_campaigns')
                     ->where([['status', '=','1'],
                        ['influncer_id',$user->id],
                        ['deleted_at',NULL]
                 ])
                     ->pluck('campaign_id')->toArray();
            //dd($favorite);

            $campaign = DB::table('campaigns')
                     ->whereIn('id',  $favorite)
                     ->orderBy('updated_at','DESC')
                     ->get();

            //dd($campaign);

          //$campaigns =  $this->campaignsTransformer->transformCollection(collect($campaigns->items()));

        //return $this->respondWithPagination([ 'data' =>  $campaigns]);

        $results = $this->campaignsTransformer->transformCollection($campaign);

        return $this->sendResponse( $results,trans('lang.readed successfully'),200);


        }

        /*$validator = Validator::make( $request->all(), [
            'id'                => 'required|exists:campaigns,id',

            'status'    => 'required'


        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        $campaign = Campaign::find( $request->id );

        $campaign->status = $request->status;

        $campaign->save();


        return $this->respondWithSuccess(trans('api_msgs.updated'));*/








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
    


   /* public function rateCampaign( Request $request )
    {

        $user =  $this->getAuthenticatedUser();

        $validator = Validator::make( $request->all(), [
            'id'    => 'required|exists:campaigns,id',
            'rate'  => 'required|max:5|min:1'
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        $rate = CampaignRate::firstOrNew(['user_id' => $user->id ,'campaign_id' => $request->id ]);
        $rate->rate     =  $request->rate;
        $rate->comment  =  $request->comment;
        $rate->save();

        $course =  Campaign::find($request->id);
        //$player_ids = $this->getUserPlayerIds($course->instructor_id);
        //Notification::create(['user_id' => $course->instructor_id ,'message' => 'يوجد تعليق جديد علي كورس '.$course->name ]);
        //sendNotification('يوجد تعليق جديد علي كورس '.$course->name , $player_ids ,['data' => ['course_id' =>  $course->id]]);
        return $this->respondWithSuccess('success');

    }*/



    public function archiveCampaigns(Request $request)
    {
        $user =  $this->getAuthenticatedUser();
        $this->campaignsTransformer->setFlag(true);
        
        if ( $request->limit ) {
                $this->setPagination($request->limit);
        }

        $this->campaignsTransformer->setFlag(true);
        //$data = Campaign::where('user_id' ,$user->id)->where('status','8')->get();
        $pagination = Campaign::where('user_id' ,$user->id)->where(function($q) {
            $q->where('status', "8")
              ->orWhere('status', "4");
        })->paginate($this->getPagination());
        $campaigns =  $this->campaignsTransformer->transformCollection(collect($pagination->items()));
        //$campaigns = $this->campaignsTransformer->transformCollection($data);
        return $this->respondWithPagination($pagination, ['data' => $campaigns ]);
        //return $this->sendResponse($campaigns, trans('lang.campaigns read succesfully'),200);
    }



}
