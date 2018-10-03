<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactUsController extends CoreController
{
    function __construct(ContactUs $model)
    {
        $this->model = $model;
        $this->show_columns_html = ['id', 'name','email'];
        $this->show_columns_select = ['id', 'name','email'];

        parent::__construct();
    }

}
