<?php

namespace App\Http\Requests\Admin\Transactions;

use App\Transactions;
use Carbon\Carbon;
use App\User;
use App\Http\Requests\Admin\BaseRequest;


class StoreTransactionsRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'                      => 'required',
            'amount'                       => 'required',
            'direction'                    => 'nullable',
            'campaign_id'                  => 'nullable',
            'offer_id'                     => 'nullable',
            'status'                       => 'nullable',
            'image'                        => 'required',
            'transaction_bank_name'        => 'required',
            'transaction_account_name'     => 'required',
            'transaction_account_number'   => 'required',
            'transaction_account_IBAN'     => 'required',
            'transaction_number'           => 'required',
            'transaction_date'             => 'nullable',
            'transaction_amount'           => 'nullable',
            'type'                         => 'nullable',

        ];
    }

    public function persist()
    {
        dd($this->request->user_id);
        $transactions =  new Transactions;
        $transactions->user_id 		= $this->request->user_id;
        $transactions->amount 	= $this->request->amount;
        $transactions->transaction_amount 	= $this->request->amount;
        $transactions->status = 1;
        $transactions->image = $this->request->image;
        $transactions->transaction_bank_name   = $this->request->transaction_bank_name;
        $transactions->transaction_account_name   = $this->request->transaction_account_name;
        $transactions->transaction_account_number   = $this->request->transaction_account_number;
        $transactions->transaction_account_IBAN   = $this->request->transaction_account_IBAN;
        $transactions->transaction_number   = $this->request->transaction_number;
        $transactions->transaction_date   = Carbon::now()->addHours(3);
        $transactions->type = 0;
        $transactions->save();
        //Transactions::create($this->request->all());
    }


}
