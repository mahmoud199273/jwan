<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfluencerCampaignsByAdmin extends Model
{
	protected $table = "influencer_campaigns_by_admin";

	protected $fillable = ['campaign_id','Influencer_id'];

    
}
