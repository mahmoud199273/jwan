<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignArea extends Model
{
	
	use SoftDeletes;
    protected $dates = ['deleted_at'];

   	protected $table = 'campaign_areas';
	protected $fillable = ['campaign_id','area_id'];
  
   public function area()
   {
   	 return $this->belongsToMany('App\Area','area_id','id');
   }
}
