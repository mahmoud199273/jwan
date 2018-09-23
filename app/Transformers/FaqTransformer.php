<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;

class FaqTransformer extends Transformer
{
    /**
     * {@inheritdoc}
     */
    public function transform( $faq ) : array
    {
        return [
            'id'            => (int) $faq->id,
            'course_id'     => (int) $faq->course_id,
            'question'      => $faq->question,
            'answer'        => $faq->answer,
            'is_public'     => (bool) $faq->is_public
        ];
    }
}