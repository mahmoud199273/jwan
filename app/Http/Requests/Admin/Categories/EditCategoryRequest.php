<?php

namespace App\Http\Requests\Admin\Categories;

use App\Http\Requests\Admin\BaseRequest;
use App\Models\Admin\Category;
use Illuminate\Validation\Rule;


class EditCategoryRequest extends BaseRequest
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

    public function persist($id)
    {
        Category::find($id)->Update($this->request->all());
    }


}
