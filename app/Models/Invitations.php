<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Invitations extends Model
{
	protected $table = "invitations";
	public $timestamps = false;
    protected $guarded = [];
}
