<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignCountry extends Model
{
    protected $table = 'campaign_countries';
	protected $fillable = ['campaign_id','country_id'];
  
   public function country()
   {
   	 return $this->belongsToMany('App\Country','country_id','id');
   }
}
