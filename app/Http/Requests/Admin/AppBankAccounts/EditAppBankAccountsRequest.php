<?php

namespace App\Http\Requests\Admin\AppBankAccounts;

use App\Http\Requests\Admin\BaseRequest;
use App\AppBankAccounts;
use Illuminate\Validation\Rule;


class EditAppBankAccountsRequest extends BaseRequest
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

    public function persist($id)
    {
        if ($this->image) {
            $image = $this->uploadImage($this->image);
            $this->offsetSet('image', $image);
        }
        AppBankAccounts::find($id)->Update($this->request->all());
    }


}
