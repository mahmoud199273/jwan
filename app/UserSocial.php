<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSocial extends Model
{
    //
    protected $table = 'user_socials';
    protected $guarded = [];

    public function user()
   {
   	 return $this->belongsTo('App\User','user_id','id');
   }
}
