<?php

namespace App\Http\Requests\Admin\Faq;

use App\Http\Requests\Admin\BaseRequest;
use App\Faq;


class EditFaqRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

         return [
            'question'      => 'required|string',
            'answer'        => 'required|string',

        ];
    }

    public function persist($id)
    {
        Faq::find($id)->Update($this->request->all());
    }


}
