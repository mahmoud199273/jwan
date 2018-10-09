<?php

namespace App\Http\Requests\Admin\Pages;

use App\Http\Requests\Admin\BaseRequest;
use App\Pages;
use Illuminate\Validation\Rule;


class EditPageRequest extends BaseRequest
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

    public function persist($id)
    {
        Pages::find($id)->Update($this->request->all());
    }


}
