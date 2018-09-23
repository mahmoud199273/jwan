<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class FeaturedAdsTransformer extends Transformer
{
    /**
     * {@inheritdoc}
     */
    public function transform($ad) : array
    {

        return [
            'id'            => (int) $ad->id,
            'image'         =>  ($ad->type == 'external') ? $ad->image : config('app.url').$ad->image,
            'url'           =>  ($ad->type == 'external') ? $ad->url : config('app.url').$ad->url,
        ];
    }
}