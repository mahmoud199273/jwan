<?php

namespace App\Http\Requests\Admin\Areas;

use App\Models\Admin\Area;
use App\Http\Requests\Admin\BaseRequest;


class StoreAreaRequest extends BaseRequest
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

    public function persist()
    {
        Area::create($this->request->all());
    }


}
