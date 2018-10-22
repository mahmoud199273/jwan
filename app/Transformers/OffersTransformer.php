<?php

namespace App\Transformers;
use App\Offer;
use App\User;
use App\Transformers\BaseTransformer as Transformer;
use App\Transformers\InfluncerTransformer;



class OffersTransformer extends Transformer
{
	public function transform($offer  ) : array
    {
        $offer = Offer::find($offer->id);

        return [
        	'id'       			=> (int) $offer->id,

            //'influncer'         => isset( $offer->influncer) ? $offer->influncer :null,

            'influncer'         => User::select('id','name','image')
                                ->where('id',$offer->influncer_id)
                                ->get(),

            'influncer_rate'    => 3,

            //'user'              => isset($offer->user) ? $offer->user :null ,

            'campaign'          => isset($offer->campaign) ? $offer->campaign :null ,

            'cost'              => $offer->cost,

            'description'       => $offer->description,


            'status'   => $offer->status,

            'created_date'      => $offer->created_at,

            'updated_date'      => $offer->updated_at,
            

        ];
    }
 




}


?>