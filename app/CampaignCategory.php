<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignCategory extends Model
{

	use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'campaign_categories';
    
	protected $fillable = ['campaign_id','category_id'];
  
   public function category()
   {
   	 return $this->belongsToMany('App\Category','category_id','id');
   }

}
