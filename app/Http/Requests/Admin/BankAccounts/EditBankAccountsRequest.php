<?php

namespace App\Http\Requests\Admin\BankAccounts;

use App\Http\Requests\Admin\BaseRequest;
use App\AppBankAccounts;
use Illuminate\Validation\Rule;


class EditBankAccountsRequest extends BaseRequest
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

    public function persist($id)
    {
        AppBankAccounts::find($id)->Update($this->request->all());
    }


}
