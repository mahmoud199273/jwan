<?php

namespace App\Http\Requests\Admin\Districts;

use App\Http\Requests\Admin\BaseRequest;
use App\District;
use Illuminate\Validation\Rule;


class EditDistrictRequest extends BaseRequest
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

    public function persist($id)
    {
        District::find($id)->Update($this->request->all());
    }


}
