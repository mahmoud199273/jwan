<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    

    protected $table = 'countries';

    protected $fillable = ['name_ar','name','code','flag'];
    
     protected $attributes = [
        'flag'=>'img/default-profile-picture.png',
    ] ;

    // public function cities()
    // {
    //     return $this->hasMany(City::class);
    // }

}
