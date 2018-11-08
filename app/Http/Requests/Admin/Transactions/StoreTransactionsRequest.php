<?php

namespace App\Http\Requests\Admin\Transactions;

use App\Transactions;
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
            'direction'                    => 'required',
            'campaign_id'                  => 'required',
            'offer_id'                     => 'required',
            'status'                       => 'required',
            'image'                        => 'required',
            'transaction_bank_name'        => 'required',
            'transaction_account_name'     => 'required',
            'transaction_account_number'   => 'required',
            'transaction_account_IBAN'     => 'required',
            'transaction_number'           => 'required',
            'transaction_date'             => 'required',
            'amounttransaction_amount'     => 'required',
            'type'                         => 'required',

        ];
    }

    public function persist()
    {
        Transactions::create($this->request->all());
    }


}
