<?php

namespace App\Http\Requests\Admin\AboutApp;

use App\AboutApp;
use App\Http\Requests\Admin\BaseRequest;


class StoreAboutAppRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body'                         => 'required',
            'body_ar'                      => 'required',
            'fb_link'                      => 'required',
            'twitter_link'                 => 'required',
            'google_link'                  => 'required',
            'insta_link'                   => 'required',
            'snap_link'                    => 'required',
            'privacy_title'                => 'required',
            'privacy_title_ar'             => 'required',
            'privacy_policy'               => 'required',
            'privacy_policy_ar'            => 'required',
            'influncer_privacy_title'      => 'required',
            'influncer_privacy_policy'     => 'required',
            'influncer_privacy_title_ar'   => 'required',
            'influncer_privacy_title_ar'   => 'required',
            'influncer_privacy_policy_ar'  => 'required',

        ];
    }

    public function persist()
    {
        AboutApp::create($this->request->all());
    }


}
