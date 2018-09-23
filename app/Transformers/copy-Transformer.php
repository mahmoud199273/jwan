<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;

class NameTransformer extends Transformer
{
    /**
     * {@inheritdoc}
     */
    public function transform($arrayName) : array
    {
        return [
            'attr'          => (int) $arrayName->id,
            'attr'          => $arrayName->attr,
            'attr'          => $arrayName->attr,
            'attr'          => $arrayName->attr,
            'attr'          => $arrayName->attr 
        ];
    }
}