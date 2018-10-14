<?php

namespace App\Http\Requests\Admin\BankAccounts;

use App\BankAccounts;
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
            'name_ar'                        => 'required|string',
            'name'                           => 'required|string',
            'desc'                           => 'required',
            'desc_ar'                        => 'required',
            'account_number'                 => 'required',
            'logo'                           => 'required',
        ];
    }

    public function persist()
    {
        BankAccounts::create($this->request->all());
    }


}
