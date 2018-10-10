<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];
	protected $table = 'nathionalities';

    public function user()
	{
    	return $this->belongsTo('App\User');
	}


}
