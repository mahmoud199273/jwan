<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserArea extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'user_areas';
	protected $fillable = ['user_id','area_id'];
  
   public function area()
   {
   	 return $this->belongsToMany('App\Area','area_id','id');
   }
}
