<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banks extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'banks';
    protected $fillable = ['name', 'name_ar', 'logo'];

    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
