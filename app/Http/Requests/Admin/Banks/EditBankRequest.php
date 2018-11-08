<?php

namespace App\Http\Requests\Admin\Banks;

use App\Http\Requests\Admin\BaseRequest;
use App\Banks;
use Illuminate\Validation\Rule;


class EditBankRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

         return [
            'name'                            => 'required|string',
            'name_ar'                         => 'required|string',
            'logo'                            => 'nullable',

        ];
    }

    public function persist($id)
    {
        if ($this->image) {
            $image = $this->uploadImage($this->image);
            $this->offsetSet('image', $image);
        }
        Banks::find($id)->Update($this->request->all());
    }


}
