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

            'minimumRate'   => $user->minimumRate,

            'facebook'     => $user->facebook,
            'facebook_follwers' => $user->facebook_follwers,

            'twitter'     => $user->twitter,
            'twitter_follwers' => $user->twitter_follwers,

            'instgrame'     => $user->instgrame,
            'instgrame_follwers' => $user->instgrame_follwers,


            'snapchat'     => $user->snapchat,
            'snapchat_follwers' => $user->snapchat_follwers,

            'linkedin'     => $user->linkedin,
            'linkedin_follwers' => $user->linkedin_follwers,

            'youtube'   => $user->youtube,
            'youtube_follwers' => $user->youtube_follwers,

            'categories' => $user->category,

            'countries_id' =>(int) $user->countries_id,

            'areas_id' =>(int) $user->areas_id

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
            'facebook_follwers' => $influncer->facebook_follwers,

            'twitter'     => $influncer->twitter,
            'twitter_follwers' => $influncer->twitter_follwers,

            'instgrame'     => $influncer->instgrame,
            'instgrame_follwers' => $influncer->instgrame_follwers,


            'snapchat'     => $influncer->snapchat,
            'snapchat_follwers' => $influncer->snapchat_follwers,

            'linkedin'     => $influncer->linkedin,
            'linkedin_follwers' => $influncer->linkedin_follwers,

            'youtube'   => $influncer->youtube,
            'youtube_follwers' => $influncer->youtube_follwers

        ];
    }*/

}