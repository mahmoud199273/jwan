<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCountry extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'user_countries';
	protected $fillable = ['user_id','country_id'];
  
   public function country()
   {
   	 return $this->belongsTo('App\Country','country_id','id');
   }
}
