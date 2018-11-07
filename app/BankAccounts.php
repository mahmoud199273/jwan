<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccounts extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'bank_accounts';
    protected $fillable = ['user_id','bank_id','account_name','IBAN','note','account_number'];
}
