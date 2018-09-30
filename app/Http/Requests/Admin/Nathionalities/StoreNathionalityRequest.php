<?php

namespace App\Http\Requests\Admin\Nathionalities;

use App\Models\Admin\Nathionalities;
use App\Http\Requests\Admin\BaseRequest;


class StoreNathionalityRequest extends BaseRequest
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
        Nathionalities::create($this->request->all());
    }


}
