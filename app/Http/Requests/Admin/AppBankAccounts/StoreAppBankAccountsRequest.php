<?php

namespace App\Http\Requests\Admin\AppBankAccounts;

use App\AppBankAccounts;
use App\Http\Requests\Admin\BaseRequest;


class StoreAppBankAccountsRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

         return [
            'name'                            => 'required|string',
            'name_ar'                         => 'required|string',
            'IBAN'                            => 'required',
            'account_number'                  => 'required',
            'account_name'                    => 'required',
            'logo'                            => 'nullable',

        ];
    }

    public function persist()
    {
        //  if ($this->logo) {
        //     $logo = $this->uploadImage($this->logo);
        //     $this->offsetSet('logo', $logo);
        // }
        AppBankAccounts::create($this->request->all());
    }


}
