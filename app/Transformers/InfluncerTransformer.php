<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;

class InfluncerTransformer extends Transformer
{
    /**
     * {@inheritdoc}
     */

    



    public function transform($user ) : array
    {
        return [
            'id'            => (int) $user->id,
            'name'          => $user->name,
            'rate'          => 3,

            'number_of_coins' => 300,
            "number_of_offers" => 12,
            "wallet" => 20,
            'email'         => $user->email,
            'phone'         => $user->phone,
            'image'         => ($user->image) ?config('app.url').$user->image : null,
            'notes'         => $user->notes,
            'gender'        =>(boolean)$user->gender,

            'nationality_id'   =>(int) $user->nationality_id,


            'account_manger' => (boolean) $user->account_manger,

            'type'          => (boolean) $user->type,

            'minimum_rate'   => $user->minimum_rate,

            'facebook'     => $user->facebook,
            'facebook_followers' => $user->facebook_followers,

            'twitter'     => $user->twitter,
            'twitter_followers' => $user->twitter_followers,

            'instagram'     => $user->instagram,
            'instagram_followers' => $user->instagram_followers,


            'snapchat'     => $user->snapchat,
            'snapchat_followers' => $user->snapchat_followers,

            'linkedin'     => $user->linkedin,
            'linkedin_followers' => $user->linkedin_followers,

            'youtube'   => $user->youtube,
            'youtube_followers' => $user->youtube_followers,

            'account_type' =>(boolean) $user->account_type,

            'categories' => $user->categories ,

            'countries' => $user->countries,

            'areas' =>$user->areas,
        ];
    }

}