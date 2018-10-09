<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{

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

        public function users()
        {

         return $this->belongsTo('App\User');
        }

}
