<?php

namespace App\Http\Requests\Admin\Complaints;

use App\Http\Requests\Admin\BaseRequest;
use App\ContactUs;
use Illuminate\Validation\Rule;


class EditComplaintRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'user_id'                        => 'required',
            'subject'                        => 'required|string',
            'message'                           => 'required|string',
        ];
    }

    public function persist($id)
    {
        ContactUs::find($id)->Update($this->request->all());
    }


}
