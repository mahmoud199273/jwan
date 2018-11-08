<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transactions extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = array();

    protected $table = 'transactions';
    protected $fillable = ['user_id', 'amount', 'direction', 'campaign_id', 'offer_id', 'status',
     'transaction_bank_name','transaction_account_name', 'transaction_account_number', 'transaction_account_IBAN', 'transaction_number', 'transaction_date', 'transaction_amount'];

        public function user()
        {

         return $this->belongsTo('App\User','user_id','id');
        }

        public function campaigns()
        {

         return $this->hasMany('App\Campaign','campaign_id','id');
        }

        public function offers()
        {

         return $this->hasMany('App\Offer','offer_id','id');
        }

}
