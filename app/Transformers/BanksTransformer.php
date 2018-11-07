<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;

class BanksTransformer extends Transformer
{
	public function transform($bank  ) : array
    {

        return [
            'id'            => 	$bank->id,
            'name'          => 	$bank->name,
            'name_ar'       => 	$bank->name_ar,
            'logo'       => 	$bank->logo,
        ];
    }





}


?>
