<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{

	protected $table = 'user_categories';
  
   public function category()
   {
   	 return $this->belongsToMany('App\Category','categories_id','id');
   }
}
