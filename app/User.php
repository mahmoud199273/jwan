<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
        public function country_id()
            {
                return $this->belongsTo(Country::class);
            }

            public function area()
            {
               return $this->hasMany('App\Area','area_id','id');
            }


    protected $fillable = [
        'name', 'email','phone', 'password','image','type','is_active','country_id','gender','video','facebook','facebook_follwers','twitter','twitter_follwers','instgrame','instgrame_follwers','snapchat','snapchat_follwers','linkedin','linkedin_follwers','youtube','youtube_follwers','notes'
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
        return $this->hasMany('App\Category','user_id','id');
    }


    public function nathionality()
    {

        return $this->hasone('App\Nathionality', 'nathionality_id', 'id');
        
    }


}
