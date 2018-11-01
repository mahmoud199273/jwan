<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'notifications';

    protected $fillable = ['user_id' , 'message'];


    protected $fillable = ['user_id' , 'message', 'message_ar', 'type', 'type_title', 'campaign_id', 'offer_id'];


    protected $hidden = ['updated_at'];
}
