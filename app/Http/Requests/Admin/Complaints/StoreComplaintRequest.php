<?php

namespace App\Http\Requests\Admin\Complaints;

use App\ContactUs;
use App\Http\Requests\Admin\BaseRequest;


class StoreComplaintRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
     public function rules()
    {

        return [
            'subject'                        => 'required|string',
            'message'                           => 'required|string',
        ];
    }

    public function persist()
    {
        ContactUs::create($this->request->all());
    }


}
