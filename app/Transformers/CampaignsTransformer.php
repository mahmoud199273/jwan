<?php

namespace App\Transformers;
use App\Attachment;
use App\Campaign;
use App\Offer;
use App\Transformers\BaseTransformer as Transformer;
use App\Transformers\InfluncerTransformer;
use App\user;
use Carbon\Carbon;



class CampaignsTransformer extends Transformer
{
	public function transform($campaign  ) : array
    {
        $campaign = Campaign::find($campaign->id);

        return [
        	'id'       			=> (int) $campaign->id,

            'title'             => $campaign->title,

            'user'              => isset($campaign->user) ? $campaign->user : null ,

            //'user'         => User::select('id','name','image')
                                //->where('id',$campaign->user_id)
                                //->get()[0],

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

            'campaign_status'   => (int) $campaign->capaign_status,

            'categories' => isset($campaign->categories) ? $campaign->categories : null,

            'countries' => isset($campaign->countries) ? $campaign->countries : null,

            'areas' => isset($campaign->areas) ? $campaign->areas : null
            

        ];
    }
 




}


?>