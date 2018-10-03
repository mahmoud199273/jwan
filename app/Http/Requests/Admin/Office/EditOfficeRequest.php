<?php

namespace App\Http\Requests\Admin\Office;

use App\Http\Requests\Admin\BaseRequest;
use App\User;
use Illuminate\Validation\Rule;


class EditOfficeRequest extends BaseRequest
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
            'image'         => 'mimes:jpg,png,jpeg|max:2048',
            'cr_licence'    => 'mimes:jpg,png,jpeg|max:2048',
            'email'         => ['required','email', Rule::unique('users')->ignore($this->id, 'id')],
            'password'      => 'nullable|string|min:6',
            'office_name'   => 'string',
            'office_address'=> 'string',
            'about_office'  => 'string',

        ];
    }

    public function persist($id)
    {
        if ($this->image) {
            $image = $this->uploadImage($this->image);
            $this->offsetSet('image', $image);
        }
        if ($this->cr_licence) {
            $cr_licence = $this->uploadImage($this->cr_licence);
            $this->offsetSet('cr_licence', $cr_licence);
        }

        User::find($id)->Update($this->request->all());
    }


}
