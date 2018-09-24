<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;

class CountryTransformer extends Transformer
{

	function __construct(AreasTransformer $areasTransformer ){
        // $this->middleware('jwt.auth');
        $this->areasTransformer = $areasTransformer;
    }

	public function transform($country  ) : array
    {
        return [
            'id'            => (int) $country->id,
            'name'          => $country->name,
            'name_ar'       => $country->name_ar,
            'code'          => $country->code,
            'areas'			=> $country->area

        ];
    }





}


?>