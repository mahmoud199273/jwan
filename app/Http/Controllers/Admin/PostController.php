<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;

class PaymentMethodController extends CoreController
{
    function __construct(Post $model)
    {
        $this->model = $model;
        $this->show_columns_select = array('id','title','body');
        $this->show_columns_html = array('id','title','body');
        parent::__construct();
    }

    public function onStore()
    {
        return $this->v([
            'title' => 'required|max:255',
            'body' => 'required|max:255',
        ]);
    }


   public function onUpdate()
    {
       return $this->v([
            'title' => 'required|max:255',
            'body' => 'required|max:255',
        ]);
    }

}
