<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    protected $table = 'notifications';



    protected $fillable = ['user_id','from_user_id' , 'message', 'message_ar', 'type', 'type_title', 'campaign_id', 'offer_id'];


    protected $hidden = ['updated_at'];
}
