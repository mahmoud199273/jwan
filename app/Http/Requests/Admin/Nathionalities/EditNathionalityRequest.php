<?php

namespace App\Http\Requests\Admin\Nathionalities;

use App\Http\Requests\Admin\BaseRequest;
use App\Models\Admin\Nathionalities;
use Illuminate\Validation\Rule;


class EditNathionalityRequest extends BaseRequest
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
        Nathionalities::find($id)->Update($this->request->all());
    }


}
