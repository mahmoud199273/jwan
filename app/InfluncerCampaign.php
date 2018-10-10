<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfluncerCampaign extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
