<?php

namespace App\Transformers;

use App\Transformers\BaseTransformer as Transformer;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use App\User;

class ChatTransformer extends Transformer
{
	public function transform($chat) : array {
		if($chat->type==5){ $type = 1; $action = true; }
		else { $type = $chat->type; $action = false; }
		$type_array = array(1=>"string", 2=>"url", 3=>"image", 4=>"file", 5=>"action");
        return [
            'id'            => (int) $chat->id,
            'type'       => $type,
            "action" => $action,
						'offer_id'		=> (int) $chat->offer_id,
						'campaign_id'		=> (int) $chat->campaign_id,
            'content'          => Crypt::decryptString($chat->content),
						'type_title'	=> $type_array[(int)$chat->type],
						'created_date'      => Carbon::parse($chat->created_at)->toDateTimeString(),
						'created_date_string'      => Carbon::createFromTimeStamp(strtotime($chat->created_at))->diffForHumans(),
            'sent_time'     => Carbon::parse($chat->created_at)->format('M,d Y H:i'),
            'sent_time_string'     => Carbon::createFromTimeStamp(strtotime($chat->created_at))->diffForHumans(),

		        'from_user_id'  => (int) $chat->from_user_id,
						'from'					=> User::where('id', $chat->from_user_id)->get()->first(),
			      'to_user_id'  => (int) $chat->to_user_id,
						'to'					=> User::where('id', $chat->to_user_id)->get()->first(),
        ];
    }
}


?>
