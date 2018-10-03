<?php

namespace App\Http\Requests\Admin\Ad;

use App\Ad;
use App\Http\Requests\Admin\BaseRequest;


class StoreAdRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'                              => 'required|string',
            'price'                             => 'required|integer',
            'address'                           => 'required|string',
            'description'                       => 'required|string',
            'contract_image'                    => 'required|mimes:jpg,png,jpeg|max:3048',
            'images'                            => 'required',
            'detailed_address'                  => 'required|string',
            'city'                              => 'required',
            'area'                              => 'required',

        ];
    }

    public function persist()
    {
         if ($this->images) {
            $image = $this->uploadImage($this->image);
            $this->offsetSet('image', $image);
            $this->offsetSet('type', 'office');
        }else{
            dd(2);
        }

        dd($this->request->all());
        // Ad::create($this->request->all());
    }


}
