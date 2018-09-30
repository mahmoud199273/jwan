<?php

namespace App\Http\Requests\Admin\Prices;

use App\Http\Requests\Admin\BaseRequest;
use App\PriceGuide;



class EditPriceRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

          return [
            'city_id'               => 'required',
            'type'                  => 'required|string',
            'date'                  => 'required|string',
            'first_half_price'      => 'required|string',
            'second_half_price'     => 'required|string',

        ];
    }

    public function persist($id)
    {
        PriceGuide::find($id)->Update($this->request->all());
    }


}
