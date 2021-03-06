<?php

namespace App\Http\Requests\Admin\Countries;

use App\Http\Requests\Admin\BaseRequest;
use App\Models\Admin\Country;
use Illuminate\Validation\Rule;


class EditCountryRequest extends BaseRequest
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
            'code'                           => 'required|numeric',
            'flag'                           => 'required',
        ];
    }

    public function persist($id)
    {
        Country::find($id)->Update($this->request->all());
    }


}
