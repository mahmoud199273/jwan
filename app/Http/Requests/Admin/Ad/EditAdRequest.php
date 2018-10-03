<?php

namespace App\Http\Requests\Admin\Ad;

use App\Http\Requests\Admin\BaseRequest;
use App\Ad;
use Illuminate\Validation\Rule;


class EditAdRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'title'                             => 'required|string',
            'price'                             => 'required|integer',
            'period'                            => 'required',
            'number_of_featured_ads'            => 'required',
            'number_of_normal_ads'              => 'required',

        ];
    }

    public function persist($id)
    {
        Ad::find($id)->Update($this->request->all());
    }


}
