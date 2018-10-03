<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SocialMedia;

class SocialMediaController extends CoreController
{
    function __construct(SocialMedia $model)
    {
        $this->model = $model;
        $this->show_columns_html = ['id', 'name'];
        $this->show_columns_select = ['id', 'name'];

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
            'name'  => 'required|max:255',
            'url'   => 'required|url',
            'icon'  => 'required',
        ]);
    }

    /**
    * Before go inside @update method
    * @return avoid
    */
   public function onUpdate()
    {
       return $this->v([
            'name'  => 'required|max:255',
            'url'   => 'required|url',
            'icon'  => 'required',
        ]);
    }

}
