<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignArea extends Model
{
   	protected $table = 'campaign_areas';
	protected $fillable = ['campaign_id','area_id'];
  
   public function area()
   {
   	 return $this->belongsToMany('App\Area','area_id','id');
   }
}
