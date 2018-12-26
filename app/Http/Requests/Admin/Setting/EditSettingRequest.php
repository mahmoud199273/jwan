<?php

namespace App\Http\Requests\Admin\Setting;

use App\Http\Requests\Admin\BaseRequest;
use App\Setting;
use Illuminate\Validation\Rule;


class EditSettingRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
   public function rules()
    {
        return [
            'campaign_period'               => 'required',
            'commission'                    => 'required',
            'tax'                           => 'required',
            
        ];
    }

    public function persist($id)
    {
        //dd($this->request->all());
        Setting::find($id)->Update($this->request->all());
        //Setting::where('id',$id)->Update($this->request->all());
    }


}