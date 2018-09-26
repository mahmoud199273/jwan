<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{

	protected $table = 'user_categories';
  
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
