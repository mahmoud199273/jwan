<?php

namespace App\Http\Requests\Admin\Faq;

use App\Faq;
use App\Http\Requests\Admin\BaseRequest;


class StoreFaqRequest extends BaseRequest
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

    public function persist()
    {
        Faq::create($this->request->all());
    }


}
