<?php

namespace App\Http\Requests\Admin\Countries;

use App\Models\Admin\Country;
use App\Http\Requests\Admin\BaseRequest;


class StoreCountryRequest extends BaseRequest
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
            'code'                           => 'required|string',
            'flag'                           => 'image',
        ];
    }

    public function persist()
    {
        Country::create($this->request->all());
    }


}
