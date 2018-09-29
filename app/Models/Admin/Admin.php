<?php

namespace App\Models;

//use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use App\Notifications\Auth\ResetAdminPassword;
//use App\Models\Permission\ProtectedUrl;

class Admin extends Authenticatable
{
    //use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password','activation','image','role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];


    public function permissions()
    {
        return $this->hasMany(Permission\RoleUrl::class,'role_id','role_id');
    }

    public function modules()
    {
        return $this->hasMany(Permission\RoleModules::class,'role_id','role_id');
    }

    public function role()
    {
        return $this->belongsTo(Permission\Role::class,'role_id','id')
                ->withDefault(['title'=>'Un Assign']);
    }



    public function getUrlsAttribute()
    {
        $ids = $this->permissions()->pluck('url_id');
        return ProtectedUrl::whereIn('id',$ids)->pluck('action');
    }

    public function getUnRoledAttribute()
    {
        $ids = $this->permissions()->pluck('url_id');
        return ProtectedUrl::whereNotIn('id',$ids);
    }



    public function getModuleAttribute()
    {
        $ids = $this->modules()->pluck('module_id');
        return Module::whereIn('id',$ids)->pluck('url');

    }

    public function getUnModuledAttribute()
    {
        $ids = $this->modules()->pluck('module_id');
        return Module::whereNotIn('id',$ids);
    }


    public function setImageAttribute($image)
    {
        $image = request()->file('image')->store('uploads');
        $this->attributes['image'] = $image;
    }


    public function setPasswordAttribute($password)
    {
        if ($password)
            $this->attributes['password'] = bcrypt($password);
        return;
    }

    // public function sendPasswordResetNotification($token)
    // {
    //     $this->notify(new ResetAdminPassword($token));
    // }
}
