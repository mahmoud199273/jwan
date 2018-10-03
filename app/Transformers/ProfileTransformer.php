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
            'rate'          => 3,
            
            'email'         => $user->email,
            'phone'         => $user->phone,
            'image'         => ($user->image) ?config('app.url').$user->image : null,
            //'is_instructor' => (boolean) $user->is_instructor,
            'notes'         => $user->notes,
            'number_of_coins' => 300,
            "number_of_offers" => 12,
            "number_of_influnceres" => 20,


            'type'          =>  $user->type,

            'facebook'     => $user->facebook,
            

            'twitter'     => $user->twitter,
            

            'instgrame'     => $user->instgrame,
            


            'snapchat'     => $user->snapchat,
            

            'linkedin'     => $user->linkedin,
            

            'youtube'   => $user->youtube,
            
            'countries_id' => $user->countries_id,


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