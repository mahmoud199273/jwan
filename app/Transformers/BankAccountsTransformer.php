<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;

class BankAccountsTransformer extends Transformer
{
	public function transform($bank  ) : array
    {

        return [
            'id'            => 	$bank->id,
            //'user_id'          => 	$bank->user_id,
            'bank_id'       => 	$bank->bank_id,
            'account_name'       => 	$bank->account_name,
            'IBAN'       => 	$bank->IBAN,
            'note'       => 	$bank->note,
            'account_number'       => 	$bank->account_number,
        ];
    }





}


?>
