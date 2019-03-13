<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Log;


class LoggerHelper{
    public static $channel = "stack";
    public static function setChannel($channelName){
        self::$channel = $channelName;
    }
    public static function log($logged_data, $flag=null, $level=1){
        $channelObj = Log::channel(self::$channel);
        $data = [];
        if($flag){
            $data[] = $flag;
            $data[] = $logged_data;
        } else $data = $logged_data;
        switch($level) {
            case 1: $channelObj->debug($data); break;
            case 2: $channelObj->info($data); break;
            case 3: $channelObj->notice($data); break;
            case 4: $channelObj->warning($data); break;
            case 5: $channelObj->error($data); break;
            case 6: $channelObj->critical($data); break;
            case 7: $channelObj->alert($data); break;
            default: $channelObj->debug($data); break;
        }
    }
}
