<?php

namespace App\Http\Requests\Admin\Districts;

use App\District;
use App\Http\Requests\Admin\BaseRequest;


class StoreDistrictRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'city_id'                        => 'required',
            'name'                           => 'required|string',
        ];
    }

    public function persist()
    {
        District::create($this->request->all());
    }


}
