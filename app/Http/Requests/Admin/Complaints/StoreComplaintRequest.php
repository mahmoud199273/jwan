<?php

namespace App\Http\Requests\Admin\Complaints;

use App\Complaint;
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
            'title'                        => 'required|string',
            'body'                           => 'required|string',
        ];
    }

    public function persist()
    {
        Complaint::create($this->request->all());
    }


}
