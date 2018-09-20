<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['country','code'];

    public function user_id()
    {
        return $this->belongsTo(User::class);
    }
}
