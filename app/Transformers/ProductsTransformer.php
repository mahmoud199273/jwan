<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class ProductsTransformer extends Transformer
{
    /**
     * {@inheritdoc}
     */
    public function transform( $product ) : array
    {

        return [
            'id'                => 	$product->id,
            'title'             => 	(App::isLocale('en'))? $product->title_en : $product->title_ar,
            'desc'              =>  (App::isLocale('en'))? $product->desc_en : $product->desc_ar,
            //'IBAN'       		=> 	$product->IBAN,
            'price'             => 	$product->price,
            'image'             => 	config('app.url').$product->image,
            //'account_name'       => 	$product->account_name,
        ];
    }
}