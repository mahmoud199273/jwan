<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{

            public function user()
            {
                return $this->belongsTo(User::class);
            }

      		public function attachments()
            {
               return $this->hasMany('App\Attachment','campaign_id','id');
            }

            

      public function categories()
    	{


         return $this->belongsToMany('App\Category', 'campaign_categories', 
                'campaign_id', 'categories_id');

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

}
