<?php

namespace App\Transformers;
use App\Attachment;
use App\Campaign;
use App\Offer;
use App\Transformers\BaseTransformer as Transformer;
use App\Transformers\InfluncerTransformer;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Area;
use Carbon\Carbon;



class CampaignsTransformer extends Transformer
{
    protected $flag = false;
    protected $user_flag = true;


    function setFlag($flag)
    {
        $this->flag = $flag; // set true to show influencers in campaigns list
    }

    function setUserFlag($user_flag)
    {
        $this->user_flag = $user_flag; // set true to show influencers in campaigns list
    }


    
	public function transform($campaign  ) : array
    {
       
			$status_array = array(0 => 'new',
			1 => 'approved',
			2 => 'rejected',
			3 => 'finished',
			4 => 'canceled',
			8 => 'canceled',
			9 => 'closed',
			5 => 'closed');
        $campaign = Campaign::find($campaign->id);


        if($campaign) $past = Carbon::parse($campaign->end_at)->isPast();
        else $past = false;

        $offers_count = 0;
        if($campaign)$offers_count = Offer::where('campaign_id',$campaign->id)->count();
        
        $ended_date_string = "تاريخ الحملة انتهى";
        if($past && (int) $campaign->status == 0 && $offers_count == 0)
        {
            $ended_date_string = "تاريخ الحملة انتهى ولم يتم التعامل معاها";
        }

        // if($campaign->id==133) dd(date($campaign->end_at) < date(now()));
        $return_array =  [
        	'id'       			=> (int) $campaign->id,
            'title'             => $campaign->title,
            //'user'              => isset($campaign->user()->select('id','name','image')->get()[0]) ? $campaign->user()->select('id','name','image')->get()[0] : null ,
            //'image'         => $camapign->($user->image) ?config('app.url').$user->image : null,
            'rate'              => (int) Offer::select(DB::raw("IF( ROUND(SUM(influncer_rate)/COUNT(influncer_rate)), ROUND(SUM(influncer_rate)/COUNT(influncer_rate)), 0 ) as rate"))->where('campaign_id', $campaign->id)->first()->rate,
            'file'              => isset($campaign->attachments) ? $campaign->attachments : null,
            'number_of_offers'  =>  Offer::where('campaign_id',$campaign->id)->count(),

            //'file'             => Attachment::select,
            'description'       => $campaign->description,
            'scenario'          => $campaign->scenario,

            'facebook'          => (int) $campaign->facebook,
            'twitter'          	=> (int) $campaign->twitter,
            'snapchat'          => (int) $campaign->snapchat,
            'youtube'          	=> (int) $campaign->youtube,
            'instgrame'      	=> (int) $campaign->instgrame,
            'male'          	=> (int) $campaign->male,
            'female'          	=> (int) $campaign->female,
            'general'          	=> (int) $campaign->general,

            'maximum_rate'      => $campaign->maximum_rate,
            'created_date'      => Carbon::parse($campaign->created_at)->toDateTimeString(),'created_date_string' => Carbon::createFromTimeStamp(strtotime($campaign->created_at))->subHour('3')->diffForHumans() ,
            'updated_date'      => Carbon::parse($campaign->updated_at)->toDateTimeString(),'updated_date_string'      => Carbon::createFromTimeStamp(strtotime($campaign->updated_at))->subHour('3')->diffForHumans() ,
            'ended_date'        => $campaign->end_at,'ended_date_string' => Carbon::createFromTimeStamp(strtotime($campaign->end_at))->diffForHumans() ,//'ended_date_string' => $ended_date_string,
            'campaign_status'   => (int) $campaign->status,
            'status'   => (int) $campaign->status,'is_extened'	=> isset($campaign->is_extened) ? $campaign->is_extened : 0,
            "is_expired" => (boolean) ( $campaign->status==1 && date($campaign->end_at) < date(now()) ),
            "offers_id" => $campaign->offers_id,
            "class" => $campaign->class

        ];

        // dd($return_array);


        if($past) $return_array['status_title'] = $ended_date_string; 
        else $return_array['status_title'] = $status_array[(int) $campaign->status]; 
        

        if($this->user_flag) // influncer app 
        {$return_array['user'] = isset($campaign->user()->select('id','name','image')->get()[0]) ? $campaign->user()->select('id','name','image')->get()[0] : null ;
        }
        if($this->flag) // user app
        {
            $return_array['influencers']  = User::select('users.id','users.name','users.image')->join('offers', 'offers.influncer_id', '=', 'users.id')->where('offers.campaign_id',$campaign->id)->get();
        }


          if($this->flag == false) // user app
        {
            $return_array['categories']  = $campaign->categories;

            $return_array['countries']   = $campaign->countries;

            // for($i=0;$i<count($return_array['countries']);$i++){

                
            //      $areas = Area::select('areas.*')->join('campaign_areas', 'campaign_areas.area_id', '=', 'areas.id')->where('areas.countries_id',$return_array['countries'][$i]['id'])->where('campaign_areas.campaign_id',$campaign->id)->groupby('areas.id')->get()->toArray();
            //       $return_array['countries'][$i]['areas'] = $areas ;
            //       //dd($return_array['countries'][$i]); 

            // }
            $return_array['areas']   = $campaign->areas;
        }

        return $return_array;
    }





}


?>
