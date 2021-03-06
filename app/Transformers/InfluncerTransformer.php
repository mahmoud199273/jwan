<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;
use Illuminate\Support\Facades\DB;
use App\Country;
use App\Offer;
use App\Notification;
use App\Nathionality;
use App\UserSocial;


class InfluncerTransformer extends Transformer
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

        $socialData = UserSocial::where('user_id', $user->id);
        if($socialData->first()) $social_info_repo = $socialData->first();
        else $social_info_repo = $user;
        

        if($this->flag) // this flag to hide unnecessary data this work only when client need to see influencer profile this function called in UserController/UserinfluncerProfile to set true
        {
            return [
                'id'            => (int) $user->id,
                'name'          => $user->name,
                'rate'          => (int) Offer::select(DB::raw("IF( ROUND(SUM(user_rate)/COUNT(user_rate)) , ROUND(SUM(user_rate)/COUNT(user_rate)), 0 ) as rate"))->where('influncer_id', $user->id)->first()->rate,
                'image'         => ($user->image) ?config('app.url').$user->image : null,
                'gender'        => (int) $user->gender,
                'notes'         => $user->notes,
                'type'          => (int) $user->type,
                'facebook'     => $user->facebook,
                'facebook_followers' => $user->facebook_follwers,
                'twitter'     => $user->twitter,
                'twitter_followers' => $user->twitter_follwers,
                'instagram'     => $user->instgrame,
                'instagram_followers' => $user->instgrame_follwers,
                'snapchat'     => $user->snapchat,
                'snapchat_followers' => $user->snapchat_follwers,
                'linkedin'     => $user->linkedin,
                'linkedin_followers' => $user->linkedin_follwers,
                'youtube'   => $user->youtube,
                'youtube_followers' => $user->youtube_follwers,
                'account_type' =>(int) $user->account_type,
            ];    
        }
        else
        {    
            return [
                'id'            => (int) $user->id,
                'name'          => $user->name,
                //'rate'          => 3,
                'rate'          => (int) Offer::select(DB::raw("IF( ROUND(SUM(user_rate)/COUNT(user_rate)) , ROUND(SUM(user_rate)/COUNT(user_rate)), 0 ) as rate"))->where('influncer_id', $user->id)->first()->rate,

                'number_of_coins' => $user->balance,
                "number_of_offers" => Offer::where('influncer_id','=',$user->id)->count(),
                "wallet"        => $user->balance,
                'email'         => $user->email,
                'phone'         => $user->phone,
                'country'       => Country::find($user->countries_id),
                'image'         => ($user->image) ?config('app.url').$user->image : null,
                'notes'         => $user->notes,
                'gender'        => (int) $user->gender,
                'notifications' => Notification::select('id')->where('is_seen',0)->where('user_id',$user->id)->count(),
                'balance' => $user->balance,

                'nationality_id'   =>(int) $user->nationality_id,
                'nationality'   =>Nathionality::select('id','name','name_ar')
                                ->where('id',$user->nationality_id)->first(),


                'account_manger' => (int) $user->account_manger,

                'type'          => (int) $user->type,

                'minimumRate'   => $user->minimumRate,


                'facebook'     => $social_info_repo->facebook,
                'facebook_followers' => $social_info_repo->facebook_follwers,
                'twitter'     => $social_info_repo->twitter,
                'twitter_followers' => $social_info_repo->twitter_follwers,
                'instagram'     => $social_info_repo->instgrame,
                'instagram_followers' => $social_info_repo->instgrame_follwers,
                'snapchat'     => $social_info_repo->snapchat,
                'snapchat_followers' => $social_info_repo->snapchat_follwers,
                'linkedin'     => $social_info_repo->linkedin,
                'linkedin_followers' => $social_info_repo->linkedin_follwers,
                'youtube'   => $social_info_repo->youtube,
                'youtube_followers' => $social_info_repo->youtube_follwers,

                'account_type' =>(int) $user->account_type,
                'categories' => $user->categories ,
                'countries' => $user->countries,
                'areas' =>$user->areas,
                "socialUpdateUnderApproval"=> (boolean) $socialData->count()
            ];
        }
    }

}