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
            'min_balance'                   => 'required',
            // 'checkVerificationCodeScenario' => 'required'
            
        ];
    }

    public function persist($id)
    {
        $params = $this->request->all();
        $params["checkVerificationCodeScenario"] = (isset($params["checkVerificationCodeScenario"]) && $params["checkVerificationCodeScenario"] == "on") ? true : false;
        // dd($params);
        Setting::find($id)->Update($params);
        //Setting::where('id',$id)->Update($this->request->all());
    }


}