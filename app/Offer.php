<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{


	use SoftDeletes;
    protected $dates = ['deleted_at'];
		
     public function campaign()
    {
        return $this->belongsTo('App\Campaign');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
