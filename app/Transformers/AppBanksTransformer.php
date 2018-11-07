<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;

class AppBanksTransformer extends Transformer
{
	public function transform($bank  ) : array
    {

        return [
            'id'            => 	$bank->id,
            'name'          => 	$bank->name,
            'name_ar'       => 	$bank->name_ar,
            'IBAN'       		=> 	$bank->IBAN,
            'account_number'       => 	$bank->account_number,
            'logo'       => 	$bank->logo,
            'account_name'       => 	$bank->account_name,
            'created_at'       => 	$bank->created_at,
            'updated_at'       => 	$bank->updated_at,
        ];
    }





}


?>
