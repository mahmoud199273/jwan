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
            'user_id'                     => 'required',
            'bank_id'                     => 'required',
            'account_name'                => 'required|string',
            'IBAN'                        => 'required',
            'note'                        => 'required',
            'account_number'              => 'required',
            
            
        ];
    }

    public function persist($id)
    {
        BankAccounts::find($id)->Update($this->request->all());
    }


}
