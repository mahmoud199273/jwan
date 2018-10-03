<?php

namespace App\Http\Requests\Admin\Services;

use App\Services;
use App\Http\Requests\Admin\BaseRequest;


class StoreServicesRequest extends BaseRequest
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
            'image'                            => 'required',

        ];
    }

    public function persist()
    {
         if ($this->image) {
            $image = $this->uploadImage($this->image);
            $this->offsetSet('image', $image);
        }
        Services::create($this->request->all());
    }


}
