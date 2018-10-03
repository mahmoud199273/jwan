<?php

namespace App\Http\Requests\Admin\Complaints;

use App\Http\Requests\Admin\BaseRequest;
use App\Complaint;
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
            'title'                        => 'required|string',
            'body'                           => 'required|string',
        ];
    }

    public function persist($id)
    {
        Complaint::find($id)->Update($this->request->all());
    }


}
