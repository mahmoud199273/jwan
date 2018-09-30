<?php

namespace App\Http\Requests\Admin\Services;

use App\Http\Requests\Admin\BaseRequest;
use App\Services;
use Illuminate\Validation\Rule;


class EditServicesRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

         return [
            'title'                            => 'required|string',
            'body'                             => 'required|string',
            'image'                            => 'nullable',

        ];
    }

    public function persist($id)
    {
        if ($this->image) {
            $image = $this->uploadImage($this->image);
            $this->offsetSet('image', $image);
        }
        Services::find($id)->Update($this->request->all());
    }


}
