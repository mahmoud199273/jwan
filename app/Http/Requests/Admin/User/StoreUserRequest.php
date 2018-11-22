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
            'image'         => 'required',
            'email'         => 'required|string|email|unique:users,email',
            'password'      => 'required|string|min:6',
            'gender'     => 'nullable',
            'account_manger'=> 'nullable',
            'notes'     => 'required',
            'type'      => 'nullable',
            'facebook'      => 'nullable',
            'twitter'      => 'nullable',
            'instagram'      => 'nullable',
            'snapchat'      => 'nullable',
            'linkedin'      => 'nullable',
            'youtube'      => 'nullable',
            'countries_id'      => 'required',
            'nationality_id'      => 'nullable',
        ];
    }

    public function persist()
    {
        // if ($this->image) {
        //     $image = $this->uploadImage($this->image);
        //     $this->offsetSet('image', $image);
        // }
        //$this->offsetSet('type', 'users');
        
        if ($this->password) {
            $password = bcrypt($this->password);
            $this->offsetSet('password', $password);
        }

        User::create($this->request->all());
    }


}
