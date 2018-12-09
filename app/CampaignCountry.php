<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignCountry extends Model
{

	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'campaign_countries';
	protected $fillable = ['campaign_id','country_id'];
  
   public function country()
   {
   	 return $this->belongsToMany('App\Country','country_id','id')->whereNull('campaign_countries.deleted_at')->withTimestamps();
   }
}
