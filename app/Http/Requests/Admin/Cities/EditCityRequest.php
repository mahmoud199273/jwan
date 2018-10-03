<?php

namespace App\Http\Requests\Admin\Cities;

use App\Http\Requests\Admin\BaseRequest;
use App\City;
use Illuminate\Validation\Rule;


class EditCityRequest extends BaseRequest
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

    public function persist($id)
    {
        City::find($id)->Update($this->request->all());
    }


}
