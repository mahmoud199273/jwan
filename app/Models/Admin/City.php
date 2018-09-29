<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name_ar','name_en','activation','country_id','image'];

    
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function areas()
    {
        return $this->hasMany(Area::class);
    }


    /**
     * auto get column with current language
     * @return column type
     */
    public function col($column)
    {
        $lang = config('app.locale');
        $column = "$column"."_"."$lang";
        return $this->$column;
    }


    public function scopeActive($query)
    {
        $query->where('activation',1);
    }

}
