<?php


    function sendNotification($account_type, $msg = 'new message',$msg_ar = 'new message ar' ,$player_id = null ,$tag_key="chat",  $data = array())
		{
			if($account_type == 0) //user
			{
					$app_id = "2a3346f8-2d2b-4658-8577-d8e8f9903932";
					$auth_key = "YjVhODBiYjMtMmZmZi00ZDc0LTgyZmYtMDNmM2U2YzY3MjVm";
			}
			elseif($account_type == 1)//influncer
			{
					$app_id = "b424f52b-e243-411c-81b0-b3cc568470b2";
					$auth_key = "YTJiZDk1OGUtZmYxMy00ZWMyLWI1YTUtNDcxODVkNjQzNWJm";
      }
       $daTags = array(array("field" => "tag","key" => "$tag_key", "relation" => "=", "value" => 1),);
        $content = array(
                         "en" => $msg,
                         "ar" => $msg_ar
                         );
        $fields = array(
                        'app_id' => "$app_id",
                        'include_player_ids' =>  $player_id,
                        'data' => $data,
                        //'filters' => $daTags,
                        'contents' => $content,
                        'content_available' => true
                        );
        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8",
                                                   "Authorization: Basic $auth_key"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    // function sendNotificationToAll($msg = '')
    // {
    //     $content = array(
    //                      "en" => "$msg"
    //                      );
		//
    //     $fields = array(
    //                     'app_id' => "6af10f82-cf99-426b-9339-717a4a9ae988",
    //                     'included_segments' => array('Active Users'),
    //                     'data' => array("foo" => "bar"),
    //                     'contents' => $content
    //                     );
		//
    //     $fields = json_encode($fields);
		//
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
    //                                                'Authorization: Basic MDhjMThkZmUtNjIzNy00MDQxLTliZjMtNDA5YjJjZWVlNDVi'));
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    //     curl_setopt($ch, CURLOPT_HEADER, FALSE);
    //     curl_setopt($ch, CURLOPT_POST, TRUE);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		//
    //     $response = curl_exec($ch);
    //     curl_close($ch);
		//
    //     return $response;
    // }
