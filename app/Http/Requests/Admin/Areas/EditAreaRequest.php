<?php

namespace App\Http\Requests\Admin\Areas;

use App\Http\Requests\Admin\BaseRequest;
use App\Models\Admin\Area;
use Illuminate\Validation\Rule;


class EditAreaRequest extends BaseRequest
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
        ];
    }

    public function persist($id)
    {
        Area::find($id)->Update($this->request->all());
    }


}
