<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;
use Illuminate\Support\Facades\DB;
use App\UserCountry;  
use App\Country;  
use App\Notification;
use App\Campaign;
use App\Offer;

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
                //'rate'          => 3,
                'rate'          => (int) Offer::select(DB::raw("IF( ROUND(SUM(influncer_rate)/COUNT(influncer_rate)), ROUND(SUM(influncer_rate)/COUNT(influncer_rate)), 0 ) as rate"))->where('user_id', $user->id)->first()->rate,
                
                'email'         => $user->email,
                'phone'         => $user->phone,
                'image'         => ($user->image) ?config('app.url').$user->image : null,
                //'is_instructor' => (boolean) $user->is_instructor,
                'notes'         => $user->notes,
                'number_of_campaigns' => Campaign::where('user_id','=',$user->id)->count(),
                "number_of_offers" => Offer::where('user_id','=',$user->id)->count(),
                "number_of_influnceres" => Offer::where('user_id','=',$user->id)->where('status','7')->count(),
                'notifications' => Notification::select('id')->where('is_seen',0)->where('user_id',$user->id)->count(),
                'balance' => $user->balance,


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