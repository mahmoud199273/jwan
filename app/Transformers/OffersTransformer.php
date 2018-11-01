<?php

namespace App\Transformers;
use App\Offer;
use App\Transformers\BaseTransformer as Transformer;
use App\Transformers\InfluncerTransformer;
use App\User;
use Carbon\Carbon;



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
                                ->get()[0],

            'influncer_rate'    => 3,

            'user'              => isset($offer->user) ? $offer->user : null,

            'campaign'          => isset($offer->campaign) ? $offer->campaign :null ,

            'cost'              => $offer->cost,

            'description'       => $offer->description,


						'status'   => $offer->status,



						'user_rate'   => $offer->user_rate,
						//'user_rate_comment'   => $offer->user_rate_comment,
						'influncer_rate'   => $offer->influncer_rate,
						//'influncer_rate_comment'   => $offer->influncer_rate_comment,

            'created_date'      => Carbon::parse($offer->created_at)->toDateTimeString(),

            'updated_date'      => Carbon::parse($offer->updated_at)->toDateTimeString(),


        ];
    }





}


?>
