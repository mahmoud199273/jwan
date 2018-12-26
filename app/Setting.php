<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Setting extends Model
{
	protected $table = "settings";
    protected $fillable = ['campaign_period','commission','tax'];
}
