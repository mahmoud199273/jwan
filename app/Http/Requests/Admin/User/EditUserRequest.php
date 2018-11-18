<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\Admin\BaseRequest;
use App\User;
use Illuminate\Validation\Rule;


class EditUserRequest extends BaseRequest
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
            'phone'         => ['required', Rule::unique('users')->ignore($this->id, 'id')],
            'image'         => 'required',
            'email'         => ['required','email', Rule::unique('users')->ignore($this->id, 'id')],
            'password'      => 'required|string|min:6',
            'notes'         => 'required',
            'type'          => 'required',
            'account_manger'=> 'nullable',
            'facebook'      => 'nullable',
            'twitter'       => 'nullable',
            'instagram'     => 'nullable',
            'snapchat'      => 'nullable',
            'linkedin'      => 'nullable',
            'youtube'       => 'nullable'

        ];
    }

    public function persist($id)
    {
        if ($this->password) {
            $password = bcrypt($this->password);
            $this->offsetSet('password', $password);
        }
        User::find($id)->Update($this->request->all());
    }


}
