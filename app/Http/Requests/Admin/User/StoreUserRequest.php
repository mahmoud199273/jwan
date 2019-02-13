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
            'name'          => 'required|string|min:3',
            'phone'         => 'required|min:9|digits:9|regex:/^[5][0-9]{4,}/|unique:users,phone|unique:users,account_type',
            'image'         => 'required',
            'email'         => 'required|string|email|unique:users,email',
            'minimumRate'   => 'sometimes|nullable|numeric|min:500|max:20000',
            'password'      => 'required|string|min:8|max:16',
            'gender'     => 'nullable',
            'account_manger'=> 'nullable',
            'notes'     => 'required|min:15',
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
