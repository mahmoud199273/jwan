<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\CorporateBooking;
use App\Http\Controllers\Controller;

class CorporateBookingController extends CoreController
{
    function __construct(CorporateBooking $model)
    {
        $this->model = $model;
        $this->show_columns_html = ['id', 'company_name','nationality','number_of_guests'];
        $this->show_columns_select = ['id', 'company_name','nationality','number_of_guests'];

        parent::__construct();
    }

}
