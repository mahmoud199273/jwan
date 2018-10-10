<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pages extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'pages';
    protected $fillable = ['name','name_ar','desc','desc_ar'];
}
