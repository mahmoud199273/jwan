<?php

namespace App\Transformers;
use App\Attachment;
use App\Campaign;
use App\Offer;
use App\Transformers\BaseTransformer as Transformer;
use App\Transformers\InfluncerTransformer;
use App\User;
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
			5 => 'closed');
        $campaign = Campaign::find($campaign->id);

        $return_array =  [
        	'id'       			=> (int) $campaign->id,

            'title'             => $campaign->title,

            //'user'              => isset($campaign->user()->select('id','name','image')->get()[0]) ? $campaign->user()->select('id','name','image')->get()[0] : null ,
            

            //'image'         => $camapign->($user->image) ?config('app.url').$user->image : null,

            'rate'              => 3,

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

            'created_date'      => Carbon::parse($campaign->created_at)->toDateTimeString(),

            'updated_date'      => Carbon::parse($campaign->updated_at)->toDateTimeString(),

            'ended_date'        => $campaign->end_at,

            'campaign_status'   => (int) $campaign->status,

            'status'   => (int) $campaign->status,
						'status_title'	=> $status_array[(int) $campaign->status],

            //'categories' => isset($campaign->categories) ? $campaign->categories : null,

            //'countries' => isset($campaign->countries) ? $campaign->countries : null,

            //'areas' => isset($campaign->areas) ? $campaign->areas : null,

			'is_extened'	=> isset($campaign->is_extened) ? $campaign->is_extened : 0


        ];

        if($this->user_flag)
        {
            $return_array['user'] = isset($campaign->user()->select('id','name','image')->get()[0]) ? $campaign->user()->select('id','name','image')->get()[0] : null ;
        }
        if($this->flag)
        {
            $return_array['influencers']  = User::select('users.id','users.name','users.image')->join('offers', 'offers.influncer_id', '=', 'users.id')->where('offers.campaign_id',$campaign->id)->get();
        }

        return $return_array;
    }





}


?>
