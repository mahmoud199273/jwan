<?php

namespace App\Http\Requests\Admin\Banks;

use App\Banks;
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
            'name_ar'                         => 'required|string',
            'logo'                            => 'required',

        ];
    }

    public function persist()
    {
        //  if ($this->logo) {
        //     $logo = $this->uploadImage($this->logo);
        //     $this->offsetSet('logo', $logo);
        // }
        Banks::create($this->request->all());
    }


}
