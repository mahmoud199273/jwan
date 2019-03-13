<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Log;


class LoggerHelper{
    public static $channel = "stack";
    public static function log($msg,$level=1){
        $channelObj = Log::channel(self::$channel);
        switch($level) {
            case 1: $channelObj->debug($msg); break;
            case 2: $channelObj->info($msg); break;
            case 3: $channelObj->notice($msg); break;
            case 4: $channelObj->warning($msg); break;
            case 5: $channelObj->error($msg); break;
            case 6: $channelObj->critical($msg); break;
            case 7: $channelObj->alert($msg); break;
            default: $channelObj->debug($msg); break;
        }
    }
}
