<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class ContactQuestionsTransformer extends Transformer
{
    /**
     * {@inheritdoc}
     */
    public function transform( $item ) : array
    {

        return [
            'id'                    => 	$item->id,
            'quest'                 => 	(App::isLocale('en'))? $item->quest_en : $item->quest_ar,
        ];
    }
}