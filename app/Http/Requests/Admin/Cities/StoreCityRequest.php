<?php

namespace App\Http\Requests\Admin\Cities;

use App\City;
use App\Http\Requests\Admin\BaseRequest;


class StoreCityRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                           => 'required|string',
            'lat'                            => 'required',
            'lng'                            => 'required',

        ];
    }

    public function persist()
    {
        City::create($this->request->all());
    }


}
