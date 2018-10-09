<?php

namespace App\Transformers;
use App\User;
use App\Campaign;
use App\Transformers\BaseTransformer as Transformer;
use App\Transformers\InfluncerTransformer;



class CampaignsTransformer extends Transformer
{
	public function transform($campaign  ) : array
    {

        return [
        	'id'       			=> (int) $campaign->id,

        	'title'          	=> $campaign->title,

            'user_id'           => (int) $campaign->user_id,

            //'image'         => $camapign->($user->image) ?config('app.url').$user->image : null,

            'rate'              => 3,

        	

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

            'categories' => $campaign->categories,

            'countries' => $campaign->countries,

            'areas' =>$campaign->areas
            

        ];
    }





}


?>