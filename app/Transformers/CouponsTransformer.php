<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class CouponsTransformer extends Transformer
{
    /**
     * {@inheritdoc}
     */
    public function transform( $coupon ) : array
    {

        return [
            'id'                    => 	$coupon->id,
            'title'                 => 	(App::isLocale('en'))? $coupon->title_en : $coupon->title_ar,
            'discount'              => 	$coupon->discount,
            'code'                  => 	$coupon->code,
            'expire_at'             => 	$coupon->expire_at,
        ];
    }
}