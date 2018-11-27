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

        $status_array = array(0 => 'عرض جديد',
			1 => 'تم الموافقة على العرض',
			2 => 'تم رفض العرض',
			3 => 'تم سداد قيمة العرض على حملة',
			4 => 'جاري العمل على الحملة',
            5 => 'تم الانتهاء و توثيق حملة',
            6 => 'عرض جديد',
			7 => 'تم قبول التوثيق واغلاق الحملة',
			8 => 'قام المؤثر بالغاء عرضه على الحملة',
			9 => 'تم الغاء الحملة');
            

        $offer = Offer::find($offer->id);

        return [
        	'id'       			=> (int) $offer->id,

            //'influncer'         => isset( $offer->influncer) ? $offer->influncer :null,

            'influncer'         => User::select('id','name','image')
                                ->where('id',$offer->influncer_id)
                                ->get()[0],

            'influncer_rate'    => 3,

            'user'              => isset($offer->user()->select('id','name','image')->get()[0]) ? $offer->user()->select('id','name','image')->get()[0] : null,

            'campaign'          => isset($offer->campaign) ? $offer->campaign :null ,

            'cost'              => $offer->cost,

            'description'       => $offer->description,


            'status'   => $offer->status,
            
            'status_title'	=> $status_array[(int) $offer->status],


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
