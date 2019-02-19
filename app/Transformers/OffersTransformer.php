<?php

namespace App\Transformers;
use App\Offer;
use App\Transformers\BaseTransformer as Transformer;
use App\Transformers\InfluncerTransformer;
use App\User;
use App\Setting;
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
			7 => ' تم قبول التوثيق ',
			8 => 'قام المؤثر بالغاء عرضه على الحملة',
			9 => 'تم إلغاء العرض');
            

        $offer = Offer::find($offer->id);

        $settings = Setting::first();
        
        $user = User::find($offer->user_id);

        if($user->user_commission)
        {
            $commission = (int)$user->user_commission;
        }
        else
        {
            $commission = (int)$settings->commission;
        }
        
        $tax = (int)$settings->tax;


        // offer cost before add commission or tax
        $total_offer_value =(int)$offer->cost; 

            // get commission value of offer
        $offer_commission = round((($total_offer_value * $commission) / 100), 2); 

            // offer cost after add commission vlaue
        $total_offer_value = $total_offer_value + $offer_commission ; 

            // get tax value from offer cost 
        $offer_tax = round((($total_offer_value * $tax) / 100), 2);

            // final offer cost after add commission and tax values
        $total_offer_value = $total_offer_value + $offer_tax ;

        return [
        	'id'       			=> (int) $offer->id,

            //'influncer'         => isset( $offer->influncer) ? $offer->influncer :null,

            'influncer'         => User::select('id','name','image','email')
                                ->where('id',$offer->influncer_id)
                                ->get()[0],

            //'influncer_rate'    => 3,

            'user'              => isset($offer->user()->select('id','name','image','email')->get()[0]) ? $offer->user()->select('id','name','image')->get()[0] : null,

            'campaign'          => isset($offer->campaign) ? $offer->campaign :null ,

            'cost'              => $offer->cost,

            'description'       => $offer->description,

            'facebook'          => $offer->facebook,
            
            'twitter'           => $offer->twitter,
            
            'snapchat'          => $offer->snapchat,
            
            'youtube'           => $offer->youtube,
            
            'instgrame'         => $offer->instgrame,


            'status'   => $offer->status,
            
            'status_title'	=> $status_array[(int) $offer->status],


			'user_rate'   => $offer->user_rate,
						//'user_rate_comment'   => $offer->user_rate_comment,
			'influncer_rate'   => $offer->influncer_rate,
						//'influncer_rate_comment'   => $offer->influncer_rate_comment,

            'created_date'      => Carbon::parse($offer->created_at)->toDateTimeString(),
            
            'created_date_string'      => Carbon::createFromTimeStamp(strtotime($offer->created_at))->diffForHumans(),
            
            'updated_date'          => Carbon::parse($offer->updated_at)->toDateTimeString(),
            
            'updated_date_string'      => Carbon::createFromTimeStamp(strtotime($offer->updated_at))->diffForHumans(),

            'commission'                => $offer_commission,

            'tax'                => $offer_tax,

            'total_offer_cost'          => $total_offer_value,


        ];
    }





}


?>
