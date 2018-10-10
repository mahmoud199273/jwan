<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialChannels extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
