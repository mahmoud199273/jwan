<?php

namespace App\Http\Requests\Admin\Office;

use App\User;
use App\Http\Requests\Admin\BaseRequest;


class StoreOfficeRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'name'          => 'required|string',
            'office_name'   => 'string',
            'office_address'=> 'string',
            'about_office'  => 'string',
            'phone'         => 'required|unique:users,phone',
            'image'         => 'mimes:jpg,png,jpeg|max:2048',
            'cr_licence'    => 'mimes:jpg,png,jpeg|max:2048',
            'email'         => 'required|string|email|unique:users,email',
            'password'      => 'required|string|min:6',

        ];
    }

    public function persist()
    {
        if ($this->image) {
            $image = $this->uploadImage($this->image);
            $this->offsetSet('image', $image);
        }

        $this->offsetSet('type', 'office');
        if ($this->cr_licence) {
            $cr_licence = $this->uploadImage($this->cr_licence);
            $this->offsetSet('cr_licence', $cr_licence);
        }

        User::create($this->request->all());
    }


}
