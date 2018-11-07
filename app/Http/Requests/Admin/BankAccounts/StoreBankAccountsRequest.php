<?php

namespace App\Http\Requests\Admin\BankAccounts;

use App\AppBankAccounts;
use App\Http\Requests\Admin\BaseRequest;


class StoreBankAccountsRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                        => 'required|string',
            'name_ar'                     => 'required|string',
            'IBAN'                        => 'required',
            'account_number'              => 'required',
            'account_name'                => 'required',
            'logo'                        => 'required',
        ];
    }

    public function persist()
    {
        AppBankAccounts::create($this->request->all());
    }


}
