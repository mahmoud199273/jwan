<?php

namespace App\Transformers;
use App\Transformers\BaseTransformer as Transformer;
use App\User;
use App\Campaign;
use App\Notification;
use Carbon\Carbon;



class NotificationsTransformer extends Transformer
{
    
	public function transform($notification  ) : array
    {
        $return_array =  [
        	'id'       			=> (int) $notification->id,
            'message'             => $notification->message,
            'message_ar'             => $notification->message_ar,
            //'type'             => $notification->type,
            'title'             => $notification->type_title,
            //'campaign_id'             => $notification->campaign_id,
            //'campaign_title'          => Campaign::where('id', $notification->campaign_id)->first()->title,
            //'offer_id'             => $notification->offer_id,
            'is_seen'             => $notification->is_seen,
            'created_at'             => $notification->created_at,
            'created_at_string'             => Carbon::createFromTimeStamp(strtotime($notification->created_at))->diffForHumans(),
        ];

        $return_array['to'] = User::select('users.id','users.name','users.image')->where('id',$notification->user_id)->first();

        $return_array['from'] = User::select('users.id','users.name','users.image')->where('id',$notification->from_user_id)->first();
      

        return $return_array;
    }





}


?>
