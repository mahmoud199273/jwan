<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Hotel\HotelType;
use App\Http\Controllers\Controller;

class HotelTypeController extends CoreController
{
    function __construct(HotelType $model)
    {
        $this->model = $model;
        $this->show_columns_html = ['id', 'name_ar', 'name_en'];
        $this->show_columns_select = ['id', 'name_ar', 'name_en'];

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
            'name_ar' => 'required|max:255',
            'name_en'  => 'required|max:255',
        ]);
    }

    /**
    * Before go inside @update method
    * @return avoid
    */
   public function onUpdate()
    {
       return $this->v([
            'name_ar' => 'required|max:255',
            'name_en'  => 'required|max:255',
        ]);
    }

}
