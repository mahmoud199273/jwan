<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;
use App\User;
use Carbon\Carbon;

class RateTransformer extends Transformer
{
    /**
     * {@inheritdoc}
     */
    public function transform( $rate ) : array
    {

        $user = User::find($rate->user_id);
        return [
            'id'            => (int) $rate->id,
            'course_id'     => (int) $rate->course_id,
            'user'          => ['id' =>  $user->id , 'name' =>  $user->name , 'image' => config('app.url').$user->user_image ],
            'rate'          => $rate->rate,
            'comment'       => $rate->comment,
            'created_at'    => Carbon::parse($rate->created_at)->format('h:m A M-d')
        ];
    }
}