<?php

namespace App\Http\Requests\Admin\Campaigns;

use App\Http\Requests\Admin\BaseRequest;
use App\Campaign;
use Illuminate\Validation\Rule;


class EditCampaignsRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'title'                             => 'required',
            'user_id'                           => 'required',
            'facebook'                          => 'required',
            'twitter'                           => 'required',
            'snapchat'                          => 'required',
            'youtube'                           => 'required',
            'instgrame'                         => 'required',
            'male'                              => 'required',
            'female'                            => 'required',
            'general'                           => 'required',
            'description'                       => 'required',
            'scenario'                          => 'required',
            'status'                            => 'required',
        ];
    }

    public function persist($id)
    {
        $this->offsetunset('campaign_categories');
        $this->offsetunset('campaign_countries');
        $this->offsetunset('campaign_areas');
        Campaign::find($id)->Update($this->request->all());
    }


}
