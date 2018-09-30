<?php

namespace App\Http\Requests\Admin\Term;

use App\Http\Requests\Admin\BaseRequest;
use App\Term;


class EditTermRequest extends BaseRequest
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

    public function persist($id)
    {
        Term::find($id)->Update($this->request->all());
    }


}
