<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppBankAccounts extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'app_bank_accounts';
    protected $fillable = ['name','name_ar','IBAN','account_number', 'account_name', 'logo'];

    // protected $hidden = [
    //     'created_at', 'updated_at','deleted_at'
    // ];
}
