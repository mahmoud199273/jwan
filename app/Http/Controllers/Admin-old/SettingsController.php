<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings;

class SettingsController extends CoreController
{
    function __construct(Settings $model)
    {
        $this->model = $model;
        $this->show_columns_html = [];
        $this->show_columns_select = [];

        parent::__construct();
    }

    public function index()
    {
        $this->pushBreadcrumb(array('Index'));

        $this->ifMethodExistCallIt('onIndex');
        $this->request->flash();

        $row = $this->model->first();

        if(!$row)
            $this->model->create(['id' => 1]);

        return $this->view('edit',array('row' => $row,
                                        'columns' => $this->show_columns_html,
                                        'breadcrumb' => $this->breadcrumb,
                                        'select_columns' => $this->show_columns_select
                                    ));
    }
    
    /**
     * Before go inside @store method
     * @return avoid
     */
    public function onStore()
    {
        return $this->v([
        ]);
    }

    /**
    * Before go inside @update method
    * @return avoid
    */
   public function onUpdate()
    {
       return $this->v([
            ]);
    }

}
