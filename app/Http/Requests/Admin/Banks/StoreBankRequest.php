<?php

namespace App\Http\Requests\Admin\Banks;

use App\Bank;
use App\Http\Requests\Admin\BaseRequest;


class StoreBankRequest extends BaseRequest
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
            'image'                           => 'required',

        ];
    }

    public function persist()
    {
         if ($this->image) {
            $image = $this->uploadImage($this->image);
            $this->offsetSet('image', $image);
        }
        Bank::create($this->request->all());
    }


}
