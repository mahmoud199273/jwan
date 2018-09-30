<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;

class NationalitiesTransformer extends Transformer
{


	public function transform($nationality  ) : array
    {
        return [
            'id'            => (int) $nationality->id,
            'name'          => $nationality->name,
            'name_ar'       => $nationality->name_ar,

        ];
    }





}


?>
