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
            'name'          => 'required|string|min:3',
            'phone'         => ['required','min:9','digits:9', Rule::unique('users','account_type')->ignore($this->id, 'id')],
            'image'         => 'required',
            'email'         => ['required','email', Rule::unique('users')->ignore($this->id, 'id')],
            'password'      => 'sometimes|nullable|min:8|max:16',
            'minimumRate'   => 'sometimes|nullable|min:500|max:20000',
            'notes'         => 'required|min:15',
            'type'          => 'nullable',
            'account_manger'=> 'nullable',
            'facebook'      => 'nullable',
            'twitter'       => 'nullable',
            'instagram'     => 'nullable',
            'snapchat'      => 'nullable',
            'linkedin'      => 'nullable',
            'youtube'       => 'nullable',
            'gender'     => 'nullable',
            'countries_id'      => 'required',
            'nationality_id'      => 'nullable',

        ];
    }

    public function persist($id)
    {
        
        if ($this->password && $this->password !='' && trim($this->password) != '' && $this->password != null) {
            $password = bcrypt($this->password);
            $this->offsetSet('password', $password);
            //$user->password = $this->password;
        }
        else
        {
            $this->offsetunset('password');
        }
        User::find($id)->Update($this->request->all());
    }


}
