<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

      		public function attachments()
            {
               return $this->hasMany('App\Attachment','campaign_id','id');
            }

            

      public function categories()
    	{


         return $this->belongsToMany('App\Category', 'campaign_categories', 
                'campaign_id', 'category_id');

    	}


    public function countries()
    	{


         return $this->belongsToMany('App\Country', 'campaign_countries', 
                'campaign_id', 'country_id');

    	}


    public function areas()
    	{

         return $this->belongsToMany('App\Area', 'campaign_areas', 
                'campaign_id', 'area_id');
    	}

        public function user()
        {
 
         return $this->belongsTo('App\User','user_id','id');
        }

}
