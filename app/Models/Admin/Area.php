<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['name_ar','name','countries_id'];



    public function country()
    {
        return $this->belongsTo(Country::class);
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


}
