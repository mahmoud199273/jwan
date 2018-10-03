<?php

namespace App\Http\Requests\Admin\Banks;

use App\Http\Requests\Admin\BaseRequest;
use App\Bank;
use Illuminate\Validation\Rule;


class EditBankRequest extends BaseRequest
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
            'account_name'                    => 'required|string',
            'account_number'                  => 'required|string',
            'iban_account_number'             => 'required|string',
            'image'                           => 'nullable',

        ];
    }

    public function persist($id)
    {
        if ($this->image) {
            $image = $this->uploadImage($this->image);
            $this->offsetSet('image', $image);
        }
        Bank::find($id)->Update($this->request->all());
    }


}
