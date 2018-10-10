<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
	protected $fillable = ['file','file_type','campaign_id'];

    public function campaign()
            {
               return $this->belongsTo('App\Campaign');
            }
    use SoftDeletes;

    protected $dates = ['deleted_at'];
}
