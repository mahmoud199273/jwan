<?php

namespace App\Http\Requests\Admin\Term;

use App\Term;
use App\Http\Requests\Admin\BaseRequest;


class StoreTermRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'term'      => 'required|string',

        ];
    }

    public function persist()
    {
        Term::create($this->request->all());
    }


}
