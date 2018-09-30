<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Invoice;
use App\Models\Reservations;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends CoreController
{
    function __construct(Invoice $model)
    {
        $this->model = $model;
        $this->show_columns_html = ['id'];
        $this->show_columns_select = ['id'];

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

    public function show($id)
    {
        $show_columns_html = array('confirmation_number','pin','name','phone', 'total_price_after_taxs', 'commission','status');
        $show_columns_select = array('confirmation_number','pin','name','phone', 'total_price_after_taxs', 'commission','status_time');
        $row = $this->model->findOrFail($id);
        $this->pushBreadcrumb(array($row->due_date));
        $reservations = Reservations::whereIn('id', $row->reservations)->get();
        return $this->view('show',array(
            'row'=>$row, 
            'reservations'=>$reservations,
            'show_columns_select'=>$show_columns_select,
            'show_columns_html'=>$show_columns_html,
            'breadcrumb'=>$this->breadcrumb,
        ));
    }


}
