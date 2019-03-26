<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    //

    public function Items()
            {
               return $this->hasMany('App\OrderItems','order_id','id');
            }
}
