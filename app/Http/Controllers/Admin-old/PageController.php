<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends CoreController
{
    function __construct(Page $model)
    {
        $this->model = $model;
        $this->show_columns_html = [ 'name_ar', 'name_en'];
        $this->show_columns_select = [ 'name_ar', 'name_en'];

        $activation = ['1' => __('lang.active'), '0' => __('lang.in-active')];
        view()->share(compact('activation'));
        parent::__construct();
    }

    /**
     * Form Builder
     * @return Array
     */


    public function Activate($id) {
        $row = $this->model->find($id);
        if($row->activation != 1) {
            $update = $this->model->find($id)->update(['activation' => '1']);
            return $this->returnMessage($update, 4);
        }
        else
            $update = $this->model->find($id)->update(['activation' => '0']);
            return $this->returnMessage($update, 5);
    }

    /**
     * Before go inside @store method
     * @return avoid
     */
    public function onStore()
    {
        return $this->v([
            'url'         => 'required',
            'name_ar'     => 'required|max:255',
            'name_en'     => 'required|max:255',
            'content_ar'  => 'required',
            'content_en'  => 'required',
        ]);
    }

    /**
    * Before go inside @update method
    * @return avoid
    */
   public function onUpdate()
    {
       return $this->v([
            'url'         => 'required',
            'name_ar'     => 'required|max:255',
            'name_en'     => 'required|max:255',
            'content_ar'  => 'required',
            'content_en'  => 'required',
        ]);
    }

}
