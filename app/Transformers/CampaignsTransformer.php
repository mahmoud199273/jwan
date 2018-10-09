<?php

namespace App\Transformers;
use App\Campaign;
use App\Transformers\BaseTransformer as Transformer;
use App\Transformers\InfluncerTransformer;



class CampaignsTransformer extends Transformer
{
	public function transform($campaign  ) : array
    {
        $campaign = Campaign::find($campaign->id);

        return [
        	'id'       			=> (int) $campaign->id,

        	'title'          	=> $campaign->title,

            'user'           => isset($campaign->user) ? $campaign->user :null ,

            //'image'         => $camapign->($user->image) ?config('app.url').$user->image : null,

            'rate'              => 3,

            'file'     => isset($campaign->attachments) ? $campaign->attachments : null,

        	

            //'image'             => config('app.url').User::find($user->image) : null,

        	'facebook'          => (boolean) $campaign->facebook,

        	'twitter'          	=> (boolean) $campaign->twitter,

            'snapchat'          => (boolean) $campaign->snapchat,

            'youtube'          	=> (boolean) $campaign->youtube,

            'instgrame'      	=> (boolean) $campaign->instgrame,

            'male'          	=> (boolean) $campaign->male,

            'female'          	=> (boolean) $campaign->female,

            'general'          	=> (boolean) $campaign->general,

            'description'       => $campaign->description,

            'scenario'      	=> $campaign->scenario,

            'maximum_rate'      => $campaign->maximum_rate,

            'created_date'      => $campaign->created_at,

            'updated_date'      => $campaign->updated_at,

            'ended_date'        => $campaign->end_at,

            'campaign_status'   => (int) $campaign->capaign_status,

            'categories' => isset($campaign->categories) ? $campaign->categories : null,

             'countries' => isset($campaign->countries) ? $campaign->countries : null,

            'areas' => isset($campaign->areas) ? $campaign->areas : null
            

        ];
    }





}


?>