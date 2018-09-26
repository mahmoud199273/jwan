<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;

class CountryTransformer extends Transformer
{



	public function transform($country  ) : array
    {
        return [
            'id'            => (int) $country->id,
            'name'          => $country->name,
            'name_ar'       => $country->name_ar,
            'code'          => $country->code,
            'flag'          => $country->flag,
            'areas'			=> $country->area

        ];
    }





}


?>