<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Chat;
class Campaign extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = array();

    protected $appends = [
        'ChatCount'
    ];

      		public function attachments()
            {
               return $this->hasMany('App\Attachment','campaign_id','id')->orderBy('file_type','asc');
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

        public function offers() 
        {

         return $this->hasMany('App\Offer','campaign_id','id');
        }

         public function byadmin()
        {

         return $this->hasMany('App\InfluencerCampaignsByAdmin','campaign_id','id');
        }

           public function chats() 
        {

         return $this->hasMany('App\Chat','campaign_id','id');
        }

        public function getChatCountAttribute()
    {
        $id = $this->id;
        $chats = Chat::join('offers','offers.id','=','chat.offer_id')->join('campaigns','campaigns.id','=','offers.campaign_id')->where('chat.campaign_id', $id)->count();
        return $chats;
    }

       public function GetChatCount($id)
    {
        //$id = $this->id;
        $chats = Chat::join('offers','offers.id','=','chat.offer_id')->join('campaigns','campaigns.id','=','offers.campaign_id')->where('chat.campaign_id', $id)->groupby('chat.offer_id')->count();
        return $chats;
    }


        


    protected $casts = [
        'is_extened' => 'string',



    ];

}
