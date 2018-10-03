<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;

class AttachmentsTransformer extends Transformer
{
	public function transform($attachment  ) : array
    {

        return [
        	'campaign_id'       => (int) $attachment->campaign_id,
            'id'                => (int) $attachment->id,
            'file'          	=> ($attachment->file) ?config('app.url').$attachment->file : null,
            'file_type'      	=>(boolean) $attachment->file_type
            

        ];
    }





}


?>