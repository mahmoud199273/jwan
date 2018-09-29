<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name_ar','name','code','flag'];


    // public function cities()
    // {
    //     return $this->hasMany(City::class);
    // }

}
