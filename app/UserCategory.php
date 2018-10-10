<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
	protected $table = 'user_categories';
	protected $fillable = ['user_id','categories_id'];
  
   public function category()
   {
   	 return $this->belongsToMany('App\Category','categories_id','id');
   }
}
