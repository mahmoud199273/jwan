<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
     public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
