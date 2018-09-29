<?php

namespace App\Models\Admin;

use Carbon\Carbon;
use App\Notifications\Auth\ResetUserPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    # type == 1 ? user
    protected $fillable = [
        'name', 'email','phone', 'password','image','type','is_active','nationality_id','account_manger','countries_id','areas_id','categories_id','gender','video','facebook','facebook_follwers','twitter','twitter_follwers','instgrame','instgrame_follwers','snapchat','snapchat_follwers','linkedin','linkedin_follwers','youtube','youtube_follwers','notes'
    ];

    protected $attributes = [
            'image'=>'img/default-profile-picture.png',
            'is_active'=>1, // 1 approved
            'type'=>1 // type 1 for regular users
    ] ;

    protected $appends = ['completed_profile','full_name','b_day','b_month','b_year'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];


    
    public function setImageAttribute($image)
    {
        if (!$image)
            return;
        $image = request()->file('image')->store('uploads/users');
        $this->attributes['image'] = $image;
    }


    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
        return ;
    }

    public function scopeUsers($query)
    {
        $query->where('type',1);
    }

    public function scopeActive($query)
    {
        $query->where('is_active',1);
    }

    public function city()
    {
        return $this->belongsTo(City::class,'city_id','id')->withDefault(['name_ar' => 'لا توجد','name_en' => 'No City']);
    }

    public function creditcard()
    {
        return $this->hasMany(CreditCard::class,'user_id','id');
    }

    /**
     * @return instance of App\Models\Reservations
     */
    public function reservations()
    {
        return $this->hasMany(Reservations::class,'user_id','id');
    }

    /**
     * @return instance of App\Models\City
     */
    public function country()
    {
        return $this->belongsTo(Country::class)->withDefault(['name_ar'=>'غير معروف']);
    }

    public function chatRooms()
    {
        //because always user will start the chat
        return $this->hasMany(ChatRooms::class,'user_id_1','id');
    }


    //completed_profile
    public function getCompletedProfileAttribute()
    {
        $is_true = true ;
        if (empty($this->name) || empty($this->phone) || empty($this->family_name)) {
            $is_true = false ;
        }
        return $is_true;
    }


    //full_name
    public function getFullNameAttribute()
    {
        return $this->name ? "{$this->name} {$this->family_name}" : "USER{$this->id}@SREER";
    }


    public function getBDayAttribute()
    {
        if ($this->birthday != '0000-00-00') {
            return Carbon::parse($this->birthday)->format('d');
        }
    }

    public function getBMonthAttribute()
    {
        if ($this->birthday != '0000-00-00') {
            return Carbon::parse($this->birthday)->format('m');
        }
    }

    public function getBYearAttribute()
    {
        if ($this->birthday != '0000-00-00') {
            return Carbon::parse($this->birthday)->format('Y');
        }
    }


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetUserPassword($token));
    }




}
