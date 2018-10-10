<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

     public function area()
    {
        return $this->hasMany('App\Area','countries_id','id');
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
