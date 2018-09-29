<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name_ar','name'];


    // public function cities()
    // {
    //     return $this->hasMany(City::class);
    // }

}
