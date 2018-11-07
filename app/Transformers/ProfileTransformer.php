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

    protected $flag = false;

    function setFlag($flag) 
    {
        $this->flag = $flag; // set true to show influencers profile data only necessary 
    }

    public function transform($user ) : array
    {

        if($this->flag) // this flag to hide unnecessary data this work only when influencer need to see client profile this function called in UserController/influncerUserProfile to set true
        {

            return [
                'id'            => (int) $user->id,
                'name'          => $user->name,
                'rate'          => 3,
                'image'         => ($user->image) ?config('app.url').$user->image : null,
                'notes'         => $user->notes,
                'type'          => (int) $user->type,
                'facebook'     => $user->facebook,
                'twitter'     => $user->twitter,
                'instgrame'     => $user->instgrame,
                'snapchat'     => $user->snapchat,
                'linkedin'     => $user->linkedin,
                'youtube'   => $user->youtube,
            ];

        }   
        else
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

}