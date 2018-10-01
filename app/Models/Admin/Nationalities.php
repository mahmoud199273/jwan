<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Nationalities extends Model
{

    protected $table = 'nationalities';

    protected $fillable = ['name_ar','name'];

}
