<?php

namespace App\Http\Requests\Admin\Pages;

use App\Pages;
use App\Http\Requests\Admin\BaseRequest;


class StorePageRequest extends BaseRequest
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
            'desc'                        => 'required',
            'desc_ar'                     => 'required',
        ];
    }

    public function persist()
    {
        Pages::create($this->request->all());
    }


}
