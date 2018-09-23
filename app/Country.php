<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
     public function area()
    {
        return $this->hasMany(Area::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
