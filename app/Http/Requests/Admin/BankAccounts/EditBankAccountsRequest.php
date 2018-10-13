<?php

namespace App\Http\Requests\Admin\BankAccounts;

use App\Http\Requests\Admin\BaseRequest;
use App\BankAccounts;
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
            'name_ar'                        => 'required',
            'name'                           => 'required',
            'desc'                           => 'required',
            'desc_ar'                        => 'required',
            'account_number'                 => 'required',
            'logo'                           => 'required',
        ];
    }

    public function persist($id)
    {
        BankAccounts::find($id)->Update($this->request->all());
    }


}
