<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCountry extends Model
{
    protected $table = 'user_countries';
	protected $fillable = ['user_id','country_id'];
  
   public function country()
   {
   	 return $this->belongsToMany('App\Country','country_id','id');
   }
}
