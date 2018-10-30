<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use SoftDeletes;
    protected $dates = ['deleted_at'];
        

            public function area()
            {
               return $this->hasMany('App\Area','area_id','id');
            }


         protected $fillable = [
        'name', 'email','phone', 'password','image','type','is_active','country_id','gender','video','facebook','facebook_follwers','twitter','twitter_follwers','instgrame','instgrame_follwers','snapchat','account_type','snapchat_follwers','linkedin','linkedin_follwers','youtube','youtube_follwers','notes'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function categories()
    {

         return $this->belongsToMany('App\Category', 'user_categories', 
                'user_id', 'categories_id');
    }

    public function countries()
    {

         return $this->belongsToMany('App\Country', 'user_countries', 
                'user_id', 'country_id');
    }

    

    public function areas()
    {

         return $this->belongsToMany('App\Area', 'user_areas', 
                'user_id', 'area_id');
    }


    public function nationality()
    {

        return $this->hasone('App\nationality', 'nationality_id', 'id');
        
    }

     public function complaint()
            {
               return $this->hasMany('App\Complaint');
            }

      public function campaign()
            {
               return $this->hasMany('App\Campaign');
            }
    public function offers()
            {
               return $this->hasMany('App\Offer','user_id','id');
            }

    protected $casts = [
        'gender' => 'string',

        'account_manger' => 'string',

        'account_type' => 'string',

        'type' => 'string',

        'is_active' => 'string',

        'account_type' => 'string'

    ];

    


}
