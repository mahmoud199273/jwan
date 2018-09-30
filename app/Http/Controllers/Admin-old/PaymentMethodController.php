<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;

class PaymentMethodController extends CoreController
{
    function __construct(PaymentMethod $model)
    {
        $this->model = $model;
        $this->show_columns_select = array('id','name_en','name_ar');
        $this->show_columns_html = array('id','name_en','name_ar');
        parent::__construct();
    }

    public function onStore()
    {
        return $this->v([
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'image' => 'required|image',
        ]);
    }


   public function onUpdate()
    {
       return $this->v([
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'image' => 'image',
        ]);
    }

}
