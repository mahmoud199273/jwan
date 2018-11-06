<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;
use App\UserCountry;  
use App\Country;  

class ProfileTransformer extends Transformer
{
    /**
     * {@inheritdoc}
     */


    public function transform($user ) : array
    {

        // dd($user_country);
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


            'type'          => (int) $user->type,

            'facebook'     => $user->facebook,
            

            'twitter'     => $user->twitter,
            

            'instgrame'     => $user->instgrame,
            


            'snapchat'     => $user->snapchat,
            

            'linkedin'     => $user->linkedin,
            

            'youtube'   => $user->youtube,
            
           //'country' => isset(UserCountry::where('user_id',$user->id)->first()->country) ? UserCountry::where('user_id',$user->id)->first()->country : null,
            'country' => Country::find($user->countries_id),


        ];
    }

}