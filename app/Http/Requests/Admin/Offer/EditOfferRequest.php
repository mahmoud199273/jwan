<?php

namespace App\Http\Requests\Admin\Offer;

use App\Http\Requests\Admin\BaseRequest;
use App\Offer;
use Illuminate\Validation\Rule;


class EditOfferRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'influncer_id'                      => 'required',
            'user_id'                           => 'required',
            'campaign_id'                       => 'required',
            'cost'                              => 'required',
            'description'                       => 'required',
            'status'                            => 'required',
        ];
    }

    public function persist($id)
    {
        Offer::find($id)->Update($this->request->all());
    }


}
