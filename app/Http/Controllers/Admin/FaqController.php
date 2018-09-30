<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Faq;

class FaqController extends CoreController
{
    function __construct(Faq $model)
    {
        $this->model = $model;
        $this->show_columns_html = ['id', 'question_ar','category'];
        $this->show_columns_select = ['id', 'question_ar','category_name'];

        $this->viewComposers();
        parent::__construct();
    }

    /**
     * Before go inside @store method
     * @return avoid
     */
    public function onStore()
    {
        return $this->v([
            'question_ar'  => 'required|max:255',
            'question_en'  => 'required|max:255',
            'answer_ar'    => 'required',
            'answer_en'    => 'required',
            'category_id'=>'required'
        ]);
    }

    /**
        * Before go inside @update method
        * @return avoid
    */
   public function onUpdate()
    {
       return $this->v([
            'question_ar'  => 'required|max:255',
            'question_en'  => 'required|max:255',
            'answer_ar'    => 'required',
            'answer_en'    => 'required',
            'category_id'=>'required'
        ]);
    }

    public function viewComposers()
    {
        $categories_list = $this->model->getCategoryList();
        return view()->share(compact('categories_list'));
    }

}
