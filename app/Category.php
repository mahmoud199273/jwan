<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

	use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function user()
    {
        return $this->belongsToMany('App\User','user_category','categories_id','user_id');
    }

    public function campaign()
    {
        return $this->belongsToMany('App\Campaign');
    }
}
