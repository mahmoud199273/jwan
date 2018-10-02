<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;

class ComplaintsTransformer extends Transformer
{
	public function transform($complaint  ) : array
    {

        return [
        	'user_id'        => (int) $complaint->user_id,
            'id'             => (int) $complaint->id,
            'title'          => $complaint->title,
            'body'      	 => $complaint->body,
            

        ];
    }





}


?>