<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'notifications';

    protected $fillable = ['user_id' , 'message'];

    protected $hidden = ['updated_at'];
}
