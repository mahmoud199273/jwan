<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
	protected $table = 'nathionalities';

    public function user()
	{
    	return $this->belongsTo('App\User');
	}


}
