<?php

namespace App\Http\Controllers\API\V1;

use App\Attachment;
use App\Campaign;
use App\CampaignArea;
use App\CampaignCategory;
use App\CampaignCountry;
use App\Http\Controllers\API\V1\BaseController as Controller;
use App\InfluncerCampaign;
use App\Notification;
use App\Offer;
use App\Setting;
use App\Transformers\CampaignsTransformer;
use App\User;
use App\UserArea;
use App\UserCategory;
use App\UserCountry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Pawlox\VideoThumbnail\Facade\VideoThumbnail;
// use Pawlox\VideoThumbnail\VideoThumbnail;


class CampignsController extends Controller
{

    protected $campaignsTransformer;

    function __construct(Request $request, CampaignsTransformer $campaignsTransformer){
        App::setlocale($request->lang);
    	$this->middleware('jwt.auth');
        $this->campaignsTransformer   = $campaignsTransformer;
    }



    public function index23( Request $request )
    {
        $influncer =  $this->getAuthenticatedUser();

        if($influncer->account_type != 1)
        {
            return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
        }

        $selected_campaigns = InfluncerCampaign::where('influncer_id',$influncer->id)->pluck('campaign_id')->toArray();
         //dd($selected_campaigns);
 
        //$orderBy = 'created_at';
        $orderBy = 'updated_at';
        $influncer_categories = UserCategory::where('user_id',$influncer->id)->pluck('categories_id')->toArray();

        $influncer_campaigns_offered = Offer::where('influncer_id',$influncer->id)->where('status','!=','2')->pluck('campaign_id')->toArray();
 
        $influncer_countries = UserCountry::where('user_id',$influncer->id)->pluck('country_id')->toArray();

        $influncer_areas = UserArea::where('user_id',$influncer->id)->pluck('area_id')->toArray();

        $areas_campaigns_id = array();
        if($influncer_areas)
        {
            //$areas_campaigns_id = Campaign::Select('campaigns.id')->join('campaign_areas','campaign_areas.campaign_id','campaigns.id')->whereNotIn('campaign_areas.area_id',$influncer_areas)->groupBy('campaigns.id')->pluck('campaigns.id')->toArray();
            
            $areas_campaigns_id = Campaign::Select('campaigns.id')
                    ->LEFTjoin('campaign_areas','campaign_areas.campaign_id','campaigns.id')
                    ->whereIn('campaign_areas.area_id',$influncer_areas)
                    ->ORwhereNull('campaign_areas.campaign_id')
                    ->groupBy('campaigns.id')->pluck('campaigns.id')->toArray();

            //$areas_campaigns_id[]= Campaign::Select('campaigns.id')->LEFTjoin('campaign_areas','campaign_areas.campaign_id','campaigns.id')->whereNull('campaign_areas.campaign_id')->groupBy('campaigns.id')->pluck('campaigns.id')->toArray();


        }
        
        //dd($areas_campaigns_id);
        //dd($influncer_categories);
 
            $campaigns = DB::table('campaigns')
                ->join('campaign_countries', 'campaigns.id', '=', 'campaign_countries.campaign_id')
                ->join('campaign_categories', 'campaigns.id', '=', 'campaign_categories.campaign_id')
                ->LEFTjoin('campaign_areas', 'campaigns.id', '=', 'campaign_areas.campaign_id');
 
            if($influncer_categories){
                $campaigns->whereIn('campaign_categories.category_id',$influncer_categories);
 
            }
 
            if($influncer_countries){
                $campaigns->whereIn('campaign_countries.country_id',$influncer_countries);
 
            }

            if($influncer_areas){
                //$influncer_areas = implode (",", $influncer_areas);
                // $campaigns->select(DB::raw('(case WHEN campaign_areas.area_id is not null THEN campaign_areas.area_id IN ('.$influncer_areas.') ELSE 1 = 1 END)'));
                //$influncer_areas = implode(',',$influncer_areas);
                //$campaigns->whereRaw("CASE WHEN campaign_areas.area_id is not null THEN campaign_areas.area_id IN ('.$influncer_areas.') ELSE 1=1 END");
                
                $campaigns->whereIn('campaigns.id',$areas_campaigns_id);
            }


            $campaigns->select('campaigns.*');
 
            if ($selected_campaigns) {
                $campaigns->whereNotIn('campaigns.id',$selected_campaigns);
            }
            if ($influncer_campaigns_offered) {
                $campaigns->whereNotIn('campaigns.id',$influncer_campaigns_offered);
            }
            if($influncer->class){
                $campaigns->where('campaigns.class',$influncer->class);
            }


//-----------This Section Search For Campaigns Selected By Admin--------------------------
            $influencerCampaignsByAdmin = DB::table('campaigns')
                            ->join('influencer_campaigns_by_admin',"campaigns.id", "=", 'influencer_campaigns_by_admin.campaign_id')
                            ->where("influencer_campaigns_by_admin.Influencer_id", $influncer->id)
                            ->groupBy('campaigns.id')->pluck('campaigns.id')->toArray();
            // dd($influencerCampaignsByAdmin);
            // dd([$selected_campaigns, $influncer_campaigns_offered]);  // where not in

            $campaigns
                    // ->orWhereIn('campaigns.id', $influencerCampaignsByAdmin)
                    // ->whereNotIn('campaigns.id', array_merge ($selected_campaigns, $influncer_campaigns_offered))
                    ;
//------------------------------------------------------------------------------------------


            $campaigns->where('campaigns.status','1')
                //->where(\DB::raw('Date(campaigns.end_at)') ,'>',\DB::raw('NOW()'))
                ->where('campaigns.end_at','>',Carbon::now()->addHours(3)->toDateTimeString())
                ->whereNull('campaigns.deleted_at')
                ->groupBy('campaigns.id')
                ->orderBy($orderBy,'DESC');
                // ->orderBy("id",'ASC');


            // if(env("APP_ENV")=="local") DB::enableQueryLog();

            // $campaigns->union($influencerCampaignsByAdmin);
            $result = $campaigns->get();

            dd($result);
            // dd(DB::getQueryLog());

            
        return $this->sendResponse( $this->campaignsTransformer->transformCollection($result),trans('lang.read succefully'),200);
    }






    private function remove_array_from_array($array, $remove_array){
        $array = array_unique($array);
        $remove_array = array_unique($remove_array);
        foreach($remove_array as $elm1){
            foreach($array as $key2=>$elm2) if($elm2==$elm1) unset($array[$key2]);
        }
        return $array;
    }

    public function index45( Request $request ) {
        $influncer =  $this->getAuthenticatedUser();
        if($influncer->account_type != 1) return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));

        $selected_campaigns_ids = InfluncerCampaign::where('influncer_id',$influncer->id)->pluck('campaign_id')->toArray();
        $orderBy = 'updated_at'; // 'created_at';
        $influncer_categories = UserCategory::where('user_id',$influncer->id)->pluck('categories_id')->toArray();
        $influncer_campaigns_offered = Offer::where('influncer_id',$influncer->id)->where('status','!=','2')->pluck('campaign_id')->toArray();
        $influncer_countries = UserCountry::where('user_id',$influncer->id)->pluck('country_id')->toArray();
        $influncer_areas = UserArea::where('user_id',$influncer->id)->pluck('area_id')->toArray();

        $where_in_ids = [];
        $where_not_in_ids = array_merge($selected_campaigns_ids, $influncer_campaigns_offered);

        if(!empty($influncer_areas)) {
            $areas_campaigns_id = Campaign::Select('campaigns.id')
                    ->LEFTjoin('campaign_areas','campaign_areas.campaign_id','campaigns.id')
                    ->whereIn('campaign_areas.area_id',$influncer_areas)
                    ->ORwhereNull('campaign_areas.campaign_id')
                    ->groupBy('campaigns.id')->pluck('campaigns.id')->toArray();
            $where_in_ids = array_merge($where_in_ids, $areas_campaigns_id);
        }

        $campaigns = DB::table('campaigns')
                ->join('campaign_countries', 'campaigns.id', '=', 'campaign_countries.campaign_id')
                ->join('campaign_categories', 'campaigns.id', '=', 'campaign_categories.campaign_id')
                ->LEFTjoin('campaign_areas', 'campaigns.id', '=', 'campaign_areas.campaign_id');
 
        if(!empty($influncer_categories)){ $campaigns->whereIn('campaign_categories.category_id',$influncer_categories); }
        if(!empty($influncer_countries)){ $campaigns->whereIn('campaign_countries.country_id',$influncer_countries); }
        // if($influncer->class){ $campaigns->where('campaigns.class',$influncer->class); }

        $final_array = $this->remove_array_from_array($where_in_ids, $where_not_in_ids);
        $campaigns->whereIn("campaigns.id",$final_array);
        
        $campaigns->select('campaigns.*');
 

//-----------This Section Search For Campaigns Selected By Admin--------------------------
            $influencerCampaignsByAdmin = DB::table('campaigns')
                            ->join('influencer_campaigns_by_admin',"campaigns.id", "=", 'influencer_campaigns_by_admin.campaign_id')
                            ->where("influencer_campaigns_by_admin.Influencer_id", $influncer->id)
                            ->groupBy('campaigns.id')->pluck('campaigns.id')->toArray();
            // dd($influencerCampaignsByAdmin, $where_not_in_ids);

            // $campaigns->orWhereIn('campaigns.id', $this->remove_array_from_array($influencerCampaignsByAdmin,$where_not_in_ids))
            //         ->whereNotIn('campaigns.id', $where_not_in_ids)
                    ;
//------------------------------------------------------------------------------------------


            $campaigns->where('campaigns.status','1')
                //->where(\DB::raw('Date(campaigns.end_at)') ,'>',\DB::raw('NOW()'))
                ->where('campaigns.end_at','>',Carbon::now()->addHours(3)->toDateTimeString())
                ->whereNull('campaigns.deleted_at')
                ->groupBy('campaigns.id')
                ->orderBy($orderBy,'DESC');
                // ->orderBy("id",'ASC');


            // if(env("APP_ENV")=="local") DB::enableQueryLog();

            // $campaigns->union($influencerCampaignsByAdmin);
            $result = $campaigns->get();

            // $res = []; foreach($result as $item) $res[] = $item->id; dd($res);

            // dd(DB::getQueryLog());

            
        return $this->sendResponse( $this->campaignsTransformer->transformCollection($result),trans('lang.read succefully'),200);
    }







    public function index( Request $request ) {
        $influncer =  $this->getAuthenticatedUser();
        
        if($influncer->account_type != 1) {return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized')); }

        $campaign_ids = InfluncerCampaign::where('influncer_id',$influncer->id)->pluck('campaign_id')->toArray();
         //dd($campaign_ids);
 
        //$orderBy = 'created_at';
        $orderBy = 'updated_at';
        $influncer_categories = UserCategory::where('user_id',$influncer->id)->pluck('categories_id')->toArray();

        $influncer_campaigns_offered = Offer::where('influncer_id',$influncer->id)->where('status','!=','2')->pluck('campaign_id')->toArray();
 
        $influncer_countries = UserCountry::where('user_id',$influncer->id)->pluck('country_id')->toArray();

        $influncer_areas = UserArea::where('user_id',$influncer->id)->pluck('area_id')->toArray();

        $areas_campaigns_id = array();
        if($influncer_areas)
        {
            //$areas_campaigns_id = Campaign::Select('campaigns.id')->join('campaign_areas','campaign_areas.campaign_id','campaigns.id')->whereNotIn('campaign_areas.area_id',$influncer_areas)->groupBy('campaigns.id')->pluck('campaigns.id')->toArray();
            
            $areas_campaigns_id = Campaign::Select('campaigns.id')->LEFTjoin('campaign_areas','campaign_areas.campaign_id','campaigns.id')->whereIn('campaign_areas.area_id',$influncer_areas)->ORwhereNull('campaign_areas.campaign_id')->groupBy('campaigns.id')->pluck('campaigns.id')->toArray();

            //$areas_campaigns_id[]= Campaign::Select('campaigns.id')->LEFTjoin('campaign_areas','campaign_areas.campaign_id','campaigns.id')->whereNull('campaign_areas.campaign_id')->groupBy('campaigns.id')->pluck('campaigns.id')->toArray();


        }
        
        //dd($areas_campaigns_id);
 
 
        //dd($influncer_categories);
 
            $campaigns = DB::table('campaigns')
            ->join('campaign_countries', 'campaigns.id', '=', 'campaign_countries.campaign_id')
            ->join('campaign_categories', 'campaigns.id', '=', 'campaign_categories.campaign_id')
            ->LEFTjoin('campaign_areas', 'campaigns.id', '=', 'campaign_areas.campaign_id');
 
            if($influncer_categories){
                $campaigns->whereIn('campaign_categories.category_id',$influncer_categories);
 
            }
 
            if($influncer_countries){
                $campaigns->whereIn('campaign_countries.country_id',$influncer_countries);
 
            }

            if($influncer_areas){
                //$influncer_areas = implode (",", $influncer_areas);
                // $campaigns->select(DB::raw('(case WHEN campaign_areas.area_id is not null THEN campaign_areas.area_id IN ('.$influncer_areas.') ELSE 1 = 1 END)'));
                //$influncer_areas = implode(',',$influncer_areas);
                //$campaigns->whereRaw("CASE WHEN campaign_areas.area_id is not null THEN campaign_areas.area_id IN ('.$influncer_areas.') ELSE 1=1 END");
                
                $campaigns->whereIn('campaigns.id',$areas_campaigns_id);
            }
 
            if($influncer->class){ $campaigns->where('campaigns.class',$influncer->class); }

            $campaigns->select('campaigns.*');
 
 
            if ($campaign_ids) {
                $campaigns->whereNotIn('campaigns.id',$campaign_ids);
            }
            if ($influncer_campaigns_offered) {
                $campaigns->whereNotIn('campaigns.id',$influncer_campaigns_offered);
            }


//-----------This Section Search For Campaigns Selected By Admin--------------------------
            $where_not_in_ids = array_merge ($campaign_ids, $influncer_campaigns_offered);
            $influencerCampaignsByAdmin = DB::table('campaigns')
                            ->join('influencer_campaigns_by_admin',"campaigns.id", "=", 'influencer_campaigns_by_admin.campaign_id')
                            ->where("influencer_campaigns_by_admin.Influencer_id", $influncer->id)
                            ->groupBy('campaigns.id')->pluck('campaigns.id')->toArray();
            // dd($influencerCampaignsByAdmin );

            // $campaigns
            // ->orWhereIn('campaigns.id', $this->remove_array_from_array($influencerCampaignsByAdmin,$where_not_in_ids))

                // ->orWhereIn('campaigns.id', $influencerCampaignsByAdmin)
                    // ->whereNotIn('campaigns.id', $where_not_in_ids)
                    // ;
//------------------------------------------------------------------------------------------


            $campaigns->where('campaigns.status','1')
                //->where(\DB::raw('Date(campaigns.end_at)') ,'>',\DB::raw('NOW()'))
                ->where('campaigns.end_at','>',Carbon::now()->addHours(3)->toDateTimeString())
                ->whereNull('campaigns.deleted_at')
                ->groupBy('campaigns.id')
                ->orderBy($orderBy,'DESC');
 
 
             $result = $campaigns->get();

            // $res = []; foreach($result as $item) $res[] = $item->id; dd($res);
            
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
            'id'    => 'required|exists:campaigns,id',
        ]);

        $this->campaignsTransformer->setFlag(false);
        
        return $validator->fails() ? $this->setStatusCode(422)->respondWithError('parameters faild validation') :
                                        $this->sendResponse( $this->campaignsTransformer->transform(Campaign::find($request->id)),
                                            trans('lang.read succefully'),200);

    }

    public function allCampaigns(Request $request)
    {
        if($request->id) $user =  User::find($request->id);
        else {
            $user =  $this->getAuthenticatedUser();
            $this->campaignsTransformer->setFlag(true);
        }
        if ( $request->limit ) { $this->setPagination($request->limit); }
        //$data = Campaign::where('user_id' ,$user->id)->get();
        $pagination = Campaign::where('campaigns.user_id' ,$user->id)->orderBy('updated_at','DESC');
        if($request->id) $pagination
                                    ->leftJoin('offers','campaigns.id','offers.campaign_id')
                                    ->whereNull("offers.id")
                                    ->select(["campaigns.*","offers.id AS offers_id"])
                                    ->whereNotIn('campaigns.status', [0,8,9,4,5]);
        else $pagination->whereNotIn('campaigns.status', [8,4]);

        $pagination = $pagination->paginate($this->getPagination());
        //dd($pagination);
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
        $settings = Setting::first();
        
        //dd((int)$user->balance,(int) $settings->min_balance);
        
        if((int)$user->balance < (int) $settings->min_balance)
        {
            return $this->setStatusCode(405)->respondWithError(trans('api_msgs.campaign_balance').(int)$settings->min_balance.trans('api_msgs.currency'));
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
            
            //'areas_id'      => 'required'
            'areas_id'      => 'nullable'
            
            
            
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
                // Attachment::create([

                    
                    // 'campaign_id'       => $campaign->id,
                    
                    // 'file' => '/public/assets/images/campaign/campaign.png', 
                    //                'file_type'     => '0',
                    //     ]);
                    
                    
                }else{
                    
                    $files  =$request->files_arr;
                    
                    $image_extensions = array('jpeg' , 'jpg', 'gif', 'png', 'tif', 'tiff');    
                    $video_extensions = array('heic','HEIC','webm','mkv','flv','flv','vob','ogg','ogg','ogv','gif','wmv','mp4','m4p','m4p','m4v','mpg','3gp');    
                    $pdf_extensions = array('pdf','doc','docx');  
                    
                    foreach ($files  as $file) {
                        //dd($file['file']);
                        $ext = pathinfo($file['file'], PATHINFO_EXTENSION);
                        $file_type = "0"; // image file 
                        $no_image_flag = 0;
                        $videoThumnb = '';
                        if(in_array($ext,$image_extensions))
                        {
                            $no_image_flag = 1;
                        }
                        if(in_array($ext,$video_extensions) ) 
                        {
                            $thumbName = time().'.png';
                            $file_type = "1"; // video file
                            // $videoThumnb = VideoThumbnail::createThumbnail(storage_path($file['file']), storage_path('public/assets/uploads'),$thumbName , 2, 600, 600);
                            
                            $thumb = VideoThumbnail::createThumbnail(public_path($file['file']), public_path("assets/uploads"), $thumbName, 3, 600, 600);
                            
                            // dd($thumb);      
                            $thumbPath = '/public/assets/uploads/'.$thumbName;
                            // dd($thumb,$thumbPath);
                            // dd(file_get_contents(public_path("assets/uploads/")));
                            
                            $frame = 10;
                            // choose file name 
                            $movie = $file['file'];
                            
                            // dd($movie);
                            // choose thumbnail name 
                            $thumbnail = $thumbName;
                            // dd($thumbName);
                            
                            // make an instance of the class 
                            // $mov = new ffmpeg_movie($movie);
                            
                            // dd($mov);
                            
                            // get the frame defined above 
                            // $frame = $mov->getFrame($frame);
                            
                            // if ($frame) {
                                //     $gd_image = $frame->toGDImage();
                                
                                //     if ($gd_image) {
                                    //         imagepng($gd_image, $thumbnail);
                                    //         imagedestroy($gd_image);
                                    //         echo '<img src="'.$thumbnail.'">';
                                    //     }
                                    // }
                                    // if($videoThumnb){
                                        //     dd($thumbPath);    
                                        // }else{
                                            //     dd('error');
                                            // }
                                            
                                            Attachment::create([
                                                
                                                'campaign_id'       => $campaign->id,
                                                
                                                'file'              => $thumbPath,               
                                                'file_type' => '0',
                                                ]);
                                                
                                            }  
                                            elseif(in_array($ext,$pdf_extensions) ) 
                                            {
                                                $file_type = "2"; // pdf file
                                            }  
                                            Attachment::create([
                                                
                                                'campaign_id'       => $campaign->id,
                                                
                                                'file'              => $file['file'],
                                                'file_type'          => $file_type
                                                ]);
                                            }
                                            
                                            if($no_image_flag != 1)
                                            {
                                                // Attachment::create([
                                                    
                                                    // 'campaign_id'       => $campaign->id,
                                                    
                                                    // 'file'              => '/public/assets/images/campaign/campaign.png',
                                                    // 'file_type'          => "0"
                                                    // ]);
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
                                                    // dd("hi");
                                                    
                                                    $areas_id  =$request->areas_id;
                                                    
                                                    if($areas_id !== null){
                                                        
                                                        foreach ($areas_id  as $id) {
                                                            CampaignArea::create([
                                                                
                                                                'campaign_id'       => $campaign->id,
                                                                
                                                                'area_id' => $id
                                                                
                                                                
                                                                ]);
                                                            }
                                                            
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
                                                    
                                                    public function isUserOwnCampaign( $user_id,$id)
                                                    {
                                                        return Campaign::where('user_id',$user_id)->where('id',$id)->first() ? true : false;
                                                    }
                                                    
                                                    public function isCampaignApproved( $campaign_id)
                                                    {
                                                        return Campaign::where('id',$campaign_id)->where('status','0')->first() ? true : false;
                                                    }
                                                    
                                                    
                                                    
                                                    public function update( Request $request )
                                                    {
                                                        $user =  $this->getAuthenticatedUser();
                                                        
                                                        if($user->account_type == '1'){
                                                            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.you do not have the rigtt to be here'));
                                                            
                                                        }
                                                        
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

            'files_arr'         => 'nullable',

            'categories_id'     => 'required',

            'countries_id'    => 'required',

            //'areas_id'      => 'required'
            'areas_id'      => 'nullable'





        ]);

         if (!$this->isUserOwnCampaign($user->id,$request->id)) {
            
           return $this->setStatusCode(409)->respondWithError(trans('api_msgs.this campaign is not for you'));
        }

         if (!$this->isCampaignApproved( $request->id)) {
           return $this->setStatusCode(409)->respondWithError(trans('api_msgs.you can not update this campaign'));
        }

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages()->first());
            
        }

        $campaign = Campaign::find( $request->id );

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

        // $campaign->created_at            = Carbon::now()->addHours(3);

        $campaign->updated_at            = Carbon::now()->addHours(3);

        //$campaign->status            = $request->status;

        $campaign->user_id          = $user->id;
        $campaign->save();
        
        Attachment::where('campaign_id', $campaign->id)->forceDelete();

        if(!$request->files_arr){
            
            // Attachment::firstOrNew([

            //     'campaign_id'       => $campaign->id,
                
            //     'file'              => '/public/assets/images/campaign/campaign.png',                'file_type'          => '0',
            //     ]);


        }else{

        $files  =$request->files_arr;

        $image_extensions = array('jpeg' , 'jpg', 'gif', 'png', 'tif', 'tiff');    
        $video_extensions = array('heic','HEIC','webm','mkv','flv','flv','vob','ogg','ogg','ogv','gif','wmv','mp4','m4p','m4p','m4v','mpg','3gp');    
        $pdf_extensions = array('pdf','doc','docx');  

        
            foreach ($files  as $file) {
                //dd($file['file']);
                $ext = pathinfo($file['file'], PATHINFO_EXTENSION);
                $file_type = "0"; // image file 
                $no_image_flag = 0;
                $videoThumnb = '';
                if(in_array($ext,$image_extensions))
                {
                    $no_image_flag = 1;
                }
                if(in_array($ext,$video_extensions) ) 
                {
                    $file_type = "1"; // video file
                    //$videoThumnb = VideoThumbnail::createThumbnail(storage_path($file['file']), storage_path('/public/assets/uploads/'), time().'.jpg', 2, 600, 600);
                }  
                elseif(in_array($ext,$pdf_extensions) ) 
                {
                    $file_type = "2"; // pdf file
                }  
                Attachment::create([

                'campaign_id'       => $campaign->id,

                'file'              => $file['file'],
                'file_type'          => $file_type
                ]);
            }

            if(!$no_image_flag)
            {
                // Attachment::create([

                // 'campaign_id'       => $campaign->id,

                // 'file'              => '/public/assets/images/campaign/campaign.png',
                // 'file_type'          => "0"
                // ]);
            }
        }

             $categories_id  =$request->categories_id;
             CampaignCategory::where('campaign_id',$campaign->id)->forceDelete();

            foreach ($categories_id  as $id) {
                CampaignCategory::create([

                'campaign_id'       => $campaign->id,

                'category_id' => $id


                      ]);
            }
            $countries_id  =$request->countries_id;
            CampaignCountry::where('campaign_id', $campaign->id)->forceDelete();
            foreach ($countries_id  as $id) {
                CampaignCountry::create([

                'campaign_id'       => $campaign->id,

                'country_id' => $id


                      ]);
            }

            $areas_id  =$request->areas_id;
           CampaignArea::where('campaign_id', $campaign->id)->forceDelete();
            if($areas_id !== null){

                foreach ($areas_id  as $id) {
                    CampaignArea::create([

                    'campaign_id'       => $campaign->id,

                    'area_id' => $id


                        ]);
                }

            }


        return $this->respondWithSuccess(trans('api_msgs.updated'));

    }

    public function extendCampaign( Request $request )
    {
        $user =  $this->getAuthenticatedUser();

        if($user->account_type != 0)
        {
            return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
        }

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
            return $this->setStatusCode(422)->respondWithError(trans('api_msgs.Already extended before'));
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

            if($user->account_type != 0)
            {
                return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
            }

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
                
                if($user->account_type != 0)
                {
                    return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
                }

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

            if($user->account_type != 1)
            {
                return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
            }
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

            if($user->account_type != 1)
            {
                return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
            }

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

        if($user->account_type != 0)
        {
            return $this->setStatusCode(404)->respondWithError(trans('api_msgs.not_authorized'));
        }
        
        $this->campaignsTransformer->setFlag(true);
        
        if ( $request->limit ) {
                $this->setPagination($request->limit);
        }

        $this->campaignsTransformer->setFlag(true);
        //$data = Campaign::where('user_id' ,$user->id)->where('status','8')->get();
        $pagination = Campaign::where('user_id' ,$user->id)->where(function($q) {
            $q->where('status', "8")
              ->orWhere('status', "4");
        })->orderBy("updated_at",'DESC')->paginate($this->getPagination());
        $campaigns =  $this->campaignsTransformer->transformCollection(collect($pagination->items()));
        //$campaigns = $this->campaignsTransformer->transformCollection($data);
        return $this->respondWithPagination($pagination, ['data' => $campaigns ]);
        //return $this->sendResponse($campaigns, trans('lang.campaigns read succesfully'),200);
    }



}
