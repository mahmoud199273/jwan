<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
