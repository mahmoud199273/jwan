<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class OrdeTransformer extends Transformer
{
    /**
     * {@inheritdoc}
     */
    public function transform( $item ) : array
    {

        return [
            'id'                    => 	$item->id,
            'name'                    => 	$item->name,
            'email'                    => 	$item->email,
            'phone'                    => 	$item->phone,
            'address'                    => 	$item->address,
            'order_date'                    => 	$item->order_date,
            'order_time'                    => 	$item->order_time,
            'price'                    => 	$item->price,
            'delivery_fees'         => 	$item->delivery_fees,
            'status'                => 	$item->status,
            'items'                 => 	$item->Items,
        ];
    }
}