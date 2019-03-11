<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class InvitationCodes extends Model
{
	protected $table = "invitationcodes";
	public $timestamps = false;
    protected $guarded = [];
}
