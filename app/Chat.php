<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    protected $table = 'chat'; 
    
    public function from_user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function to_user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
    
    public function offer()
    {
          return $this->belongsTo(Offer::class);
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];
     

}
