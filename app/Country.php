<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
     public function area()
    {
        return $this->hasMany('App\Area','countries_id','id');
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
