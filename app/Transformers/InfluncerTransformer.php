<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;
use App\Country;

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
            'country' => Country::find($user->countries_id),
            'image'         => ($user->image) ?config('app.url').$user->image : null,
            'notes'         => $user->notes,
            'gender'        =>$user->gender,


            'nationality_id'   =>(int) $user->nationality_id,


            'account_manger' => (int) $user->account_manger,

            'type'          => (int) $user->type,

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

            'account_type' =>(int) $user->account_type,

            'categories' => $user->categories ,

            'countries' => $user->countries,

            'areas' =>$user->areas,
        ];
    }

}