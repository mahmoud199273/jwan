<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;

class NathionalitiesTransformer extends Transformer
{


	public function transform($nathionality  ) : array
    {
        return [
            'id'            => (int) $nathionality->id,
            'name'          => $nathionality->name,
            'name_ar'       => $nathionality->name_ar,

        ];
    }





}


?>