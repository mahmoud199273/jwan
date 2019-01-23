<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{

 
	use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = array();
		
     public function campaign()
    {
        return $this->belongsTo('App\Campaign');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id')->withDefault(['name' => 'removed']);
    }

     public function influncer()
    {
        return $this->belongsTo('App\User','influncer_id','id');
    }

    public function chat()
    {
        return $this->hasMany('App\Chat','offer_id','id');
    }
    

}
