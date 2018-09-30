<?php

namespace App\Http\Requests\Admin\User;

use App\User;
use App\Http\Requests\Admin\BaseRequest;


class StoreUserRequest extends BaseRequest
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
            'phone'         => 'required|unique:users,phone',
            'image'         => 'mimes:jpg,png,jpeg|max:2048',
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
        $this->offsetSet('type', 'user');

        User::create($this->request->all());
    }


}
