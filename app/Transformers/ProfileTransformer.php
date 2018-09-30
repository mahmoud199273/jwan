<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;

class ProfileTransformer extends Transformer
{
    /**
     * {@inheritdoc}
     */

    



    public function transform($user ) : array
    {
        return [
            'id'            => (int) $user->id,
            'name'          => $user->name,
            
            'email'         => $user->email,
            'phone'         => $user->phone,
            'image'         => ($user->image) ?config('app.url').$user->image : null,
            //'is_instructor' => (boolean) $user->is_instructor,
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

            'categories' => $user->categories ,

            'countries' => $user->countries,

            'areas' =>$user->areas,

        ];
    }

   /* public function transform($influncer ) : array
    {
        return [
            'id'            => (int) $influncer->id,
            'name'          => $influncer->name,
            
            'email'         => $influncer->email,
            'phone'         => $influncer->phone,
            'image'         => ($influncer->image) ?config('app.url').$influncer->user_image : null,
            //'is_instructor' => (boolean) $user->is_instructor,
            'notes'         => $influncer->notes,

            'gender'        =>(boolean)$influncer->gender,

            'nationality'   => $influncer->nationality,

            'account_manger' => (boolean) $influncer->account_manger,

            'type'          => (boolean) $influncer->type,

            'facebook'     => $influncer->facebook,
            'facebook_followers' => $influncer->facebook_followers,

            'twitter'     => $influncer->twitter,
            'twitter_followers' => $influncer->twitter_followers,

            'instagram'     => $influncer->instagram,
            'instagram_followers' => $influncer->instagram_followers,


            'snapchat'     => $influncer->snapchat,
            'snapchat_followers' => $influncer->snapchat_followers,

            'linkedin'     => $influncer->linkedin,
            'linkedin_followers' => $influncer->linkedin_followers,

            'youtube'   => $influncer->youtube,
            'youtube_followers' => $influncer->youtube_followers

        ];
    }*/

}