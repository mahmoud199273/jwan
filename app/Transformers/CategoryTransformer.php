<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;
use Illuminate\Support\Facades\App;

class CategoryTransformer extends Transformer
{
    /**
     * {@inheritdoc}
     */
    public function transform($category) : array
    {
        $lang = App::getLocale();

        return [
            'id'            => (int) $category->id,
            'name'          => ($lang == 'en') ? $category->name_en : $category->name_ar,
            'image'         => config('app.url').$category->image
        ];
    }
}