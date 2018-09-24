<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;

class AreasTransformer extends Transformer
{
	public function transform($area  ) : array
    {

        return [
        	'countries_id'  => (int) $area->countries_id,
            'id'            => (int) $area->id,
            'name'          => $area->name,
            'name_ar'       => $area->name_ar,
            

        ];
    }





}


?>