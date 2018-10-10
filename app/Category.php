<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

	use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function user()
    {
        return $this->belongsToMany('App\User','user_category','categories_id','user_id');
    }

    public function campaign()
    {
        return $this->belongsToMany('App\Campaign');
    }
}
