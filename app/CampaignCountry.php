<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignCountry extends Model
{

	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'campaign_countries';
	protected $fillable = ['campaign_id','country_id'];
  
   public function country()
   {
   	 return $this->belongsToMany('App\Country','country_id','id');
   }
}
