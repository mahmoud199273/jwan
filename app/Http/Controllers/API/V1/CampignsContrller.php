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
use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CampignsContrller extends Controller
{

    protected $campaignsTransformer;

    function __construct(Request $request, CampaignsTransformer $campaignsTransformer){
        App::setlocale($request->lang);
    	$this->middleware('jwt.auth');
        $this->campaignsTransformer   = $campaignsTransformer;
    }


   /* public function allCampaigns( Request $request )
    {
        $user =  $this->getAuthenticatedUser();

        $orderBy = 'created_at';

        $campaigns = DB::table('campaigns')

            ->join('campaign_countries', 'campaigns.id', '=', 'campaign_countries.campaign_id')

            ->join('campaign_categories', 'campaigns.id', '=', 'campaign_categories.campaign_id')

            ->join('campaign_areas', 'campaigns.id', '=', 'campaign_areas.campaign_id')


            // ->join('users', 'users.id', '=', 'campaigns.user_id')

            ->join('user_countries', 'campaign_countries.country_id', '=', 'user_countries.country_id')

            ->join('user_categories', 'campaign_categories.category_id', '=', 'user_categories.categories_id')

            ->join('user_areas', 'campaign_areas.area_id', '=', 'user_areas.area_id')

            ->select('campaigns.*')

            // ->where([
            //     ['campaign_countries.country_id','=','user_countries.country_id'],

            //     ['campaign_categories.category_id','=','user_countries.categories_id'],

            //     ['campaign_areas.area_id','=','user_areas.area_id'],

            //     ['capaign_status','1']


            //     ])

            ->groupBy('campaigns.id')

            // ->orderBy($orderBy,'DESC')

            ->get();
            dd($campaigns);


        Campaign::where('capaign_status','1')->get();
        return $this->sendResponse( $this->campaignsTransformer->transformCollection($campaigns),'read succefully',200);   
    }*/

     public function allCampaigns( Request $request )
     {
         $user =  $this->getAuthenticatedUser();
         $campaigns = Campaign::where('capaign_status','1')->get();
         return $this->sendResponse( $this->campaignsTransformer->transformCollection($campaigns),'read succefully',200);   
     }


   /* public function coursesByCategoryId(Request $request , $id)
    {
        $validator = Validator::make( ['id' =>  $request->id ], [
            'id'    => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        if ($request->limit) {
            $this->setPagination($request->limit);
        }

        $pagination = Course::where('category_id' , $request->id)->paginate($this->getPagination());

        $courses = $this->courseTransformer->transformCollection(collect($pagination->items()));

        return $this->respondWithPagination($pagination ,['data' =>  $courses]);
    }


    public function getAllCourses( Request $request )
    {
    	if ( $request->limit ) {
    		$this->setPagination($request->limit);
    	}

    	$orderBy = 'created_at';

    	if ($request->sort == 'latest') {
    		$orderBy = 'created_at';
    	}elseif ($request->sort == 'rate') {
    		$orderBy = 'rate';
    	}

    	if ($request->q) {
    		$q = $request->q;

	    	$pagination = Course::join('course_rates','course_rates.course_id','=','courses.id')
	    								   ->join('users','courses.instructor_id','=','users.id')
	    	                               ->select('courses.*','users.name',DB::raw('SUM(course_rates.rate) as rate'))
	                                        ->where([
	                                            ['courses.is_active', '1'] ,
	                                            ['courses.name', 'LIKE', '%'.$q .'%']
	                                        ])
	                                        ->orWhere([
	                                        	['courses.is_active', '1'] ,
	                                            ['users.name', 'LIKE', '%'.$q .'%']
	                                        ])
	    	                               ->groupBy('courses.id')
	    	                               ->orderBy($orderBy,'DESC')
	    	                               ->paginate($this->getPagination());
    	}else{
    		$pagination = Course::join('course_rates','course_rates.course_id','=','courses.id')
	    								   ->join('users','courses.instructor_id','=','users.id')
	    	                               ->select('courses.*','users.name',DB::raw('SUM(course_rates.rate) as rate'))
	    	                               ->groupBy('courses.id')
	    	                               ->orderBy($orderBy,'DESC')
	    	                               ->paginate($this->getPagination());

    	}

    	$courses =  $this->courseTransformer->transformCollection(collect($pagination->items()));

    	return $this->respondWithPagination( $pagination, [ 'data' =>  $courses ]);
    }*/



    public function show( Request $request , $id )
    {

        $validator = Validator::make( ['id' =>  $request->id ], [
            'id'    => 'required|exists:campaigns,id',
        ]);
        return $validator->fails() ? $this->setStatusCode(422)->respondWithError('parameters faild validation') :
                                        $this->sendResponse( $this->campaignsTransformer->transform(Campaign::find($request->id)),'read succefully',200);

    }

    public function index(Request $request)
    {
    # code...
        $user =  $this->getAuthenticatedUser();

        if ( $request->limit ) {
                $this->setPagination($request->limit);
            }

        $campaigns = $this->campaignsTransformer->transformCollection(Campaign::all());

        return $this->sendResponse($campaigns, 'campaigns read succesfully',200);
    }




    public function store( Request $request )
    {
        $user =  $this->getAuthenticatedUser();

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

            //'created_date'      => 'required',

            //'updated_date'      => 'required',

            //'capaign_status'    => 'required',

            'files_arr'         => 'required',

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

        //$campaign->created_date            = $request->created_date;

        //$campaign->updated_date            = $request->updated_date;

        //$campaign->capaign_status            = $request->capaign_status;

        $campaign->user_id          = $user->id;

        $campaign->save();

        $files  =$request->files_arr;

            foreach ($files  as $file) {
                //dd($file['file']);
                Attachment::create([

                'campaign_id'       => $campaign->id,

                'file'              => $file['file']

                //'file_type'          => $file['type']



                      ]);
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

            'created_date'      => 'required',

            'updated_date'      => 'required',

            'capaign_status'    => 'required'


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

        $campaign->created_date     = $request->created_date;

        $campaign->updated_date     = $request->updated_date;

        $campaign->user_id          = $user->id;

        $campaign->save();


        return $this->respondWithSuccess(trans('api_msgs.updated'));

    }*/

    public function extendCampaign( Request $request )
    {
        //$user =  $this->getAuthenticatedUser();

        $settings = DB::table('settings')->first();

        //$settings = Setting::find('campaign_period');

       // $settings = Setting::latest()->get();

        $amount = $settings->campaign_period;

        $validator = Validator::make( $request->all(), [
            'id'                => 'required|exists:campaigns,id',

        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }




        $campaign = Campaign::find( $request->id );
        $end_date =  Carbon::parse($campaign->end_at);
        $end_date = $end_date->addDays($amount);

        $campaign->end_at = $end_date;

        $campaign->save();


        return $this->respondWithSuccess(trans('api_msgs.extended'));

    }





     public function approveCampaign( Request $request )
    {
        //$user =  $this->getAuthenticatedUser();
        $validator = Validator::make( $request->all(), [
            'id'                => 'required|exists:campaigns,id'


        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        //$campaigns = DB::table('campaigns')->first();

        
        $campaign = Campaign::find( $request->id );

        if($campaign->capaign_status == '0'){

            $campaign->capaign_status = '1';
            
            $campaign->save();
        }

        return $this->respondWithSuccess(trans('api_msgs.updated'));
    }



         public function status(Request $request)

        {
            $user =  $this->getAuthenticatedUser();

            $validator = Validator::make( $request->all(), [
            'campaign_id'                => 'required',
            'status'                     => 'required'

            ]);

            if ($validator->fails()) {
                return $this->setStatusCode(422)->respondWithError($validator->messages());
                return $this->setStatusCode(422)->respondWithError('parameters faild validation');
            }

            $influncercamapign = new InfluncerCampaign;

            $influncercamapign->campaign_id    = $request->campaign_id;

            $influncercamapign->status         = $request->status;

            $influncercamapign->user_id        = $user->id;

            $influncercamapign->save();

            return $this->respondWithSuccess(trans('api_msgs.set status successfully'));

            
        }


        public function skipped(Request $request)

        {
            $user =  $this->getAuthenticatedUser();

            $skipped = DB::table('influncer_campaigns')
                     ->where('status', '=', '0')
                     ->pluck('campaign_id')->toArray();
            //dd($skipped);

            $campaign = DB::table('campaigns')
                     ->whereIn('id',  $skipped)
                     ->get();

           //dd($campaign);

            //$result =  $this->campaignsTransformer->transformCollection(collect($campaign->items()));
    
         //return $this->respondWithPagination($campaign,[ 'data' =>  $campaignsTransformer]);

        //return $this->respond( ['data' => $this->campaignsTransformer->transformCollection(Campaign::where('capaign_status','1')->get())]);

        //return $this->respond($campaign ,['data' =>  $result]);

         $result = $this->campaignsTransformer->transformCollection($campaign);

        return $this->sendResponse( $result,'readed successfully',200); 

            
        }

        public function favorite(Request $request)

        {
            $user =  $this->getAuthenticatedUser();

            $favorite = DB::table('influncer_campaigns')
                     ->where('status', '=','1')
                     ->pluck('campaign_id')->toArray();
            //dd($favorite);

            $campaign = DB::table('campaigns')  
                     ->whereIn('id',  $favorite)
                     ->get();

            //dd($campaign);

          //$campaigns =  $this->campaignsTransformer->transformCollection(collect($campaigns->items()));
    
        //return $this->respondWithPagination([ 'data' =>  $campaigns]);

        $results = $this->campaignsTransformer->transformCollection($campaign);

        return $this->sendResponse( $results,'readed successfully',200); 

            
        }
         
        /*$validator = Validator::make( $request->all(), [
            'id'                => 'required|exists:campaigns,id',

            'capaign_status'    => 'required'


        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        $campaign = Campaign::find( $request->id );

        $campaign->capaign_status = $request->capaign_status;

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






}
