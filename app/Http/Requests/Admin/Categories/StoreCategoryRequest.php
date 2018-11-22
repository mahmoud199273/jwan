<?php

namespace App\Http\Requests\Admin\Categories;

use App\Category;
use App\Http\Requests\Admin\BaseRequest;


class StoreCategoryRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_ar'                        => 'required|string',
            'name'                           => 'required|string',
        ];
    }

    public function persist()
    {
        Category::create($this->request->all());
    }


}
