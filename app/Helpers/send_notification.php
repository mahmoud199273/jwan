<?php


function sendNotification($msg = 'new message', $msg_ar = 'رسالة جديدة', $player_id = null ,  $data = array() ){
		$content = array(
			"en" => $msg,
			"ar" => $msg_ar
			);

		$fields = array(
			'app_id' => "9ba21795-7091-41ff-b1d1-b2768149d939",
            'include_player_ids' =>  $player_id,
            'data' => $data,
			'contents' => $content,
			'content_available' => true
		);

		$fields = json_encode($fields);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
												   'Authorization: Basic MGUwODRmMTUtY2ZhZS00ZjViLTg5ODQtZDNiNWQ0MGQ1ODdl '));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}
