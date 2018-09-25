<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;

use App\Transformers\ProfileTransformer;

class CategoriesTransformer extends Transformer
{
    public function transform($category  ) : array
    {

        return [
            
            'id'            => (int) $category->id,
            'name'          => $category->name,
            'name_ar'       => $category->name_ar,
            

        ];
    }





}


?>