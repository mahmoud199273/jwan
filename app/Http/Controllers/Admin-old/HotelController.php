<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Country;
use App\Models\Hotel\Hotel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\Auth\HotelActivated;

class HotelController extends CoreController
{
    function __construct(Hotel $model)
    {
        $this->model = $model;
        $this->show_columns_html = ['id', 'name', 'phone', 'email'];
        $this->show_columns_select = ['id', 'name', 'phone', 'email'];
        parent::__construct();
    }

    /**
     * Your custom query to show data in index
     * @return json Instance OF $this->model
     */

    public function index()
    {
        $this->pushBreadcrumb(array('Index'));

        $this->ifMethodExistCallIt('onIndex');
        $this->request->flash();

        $rows = $this->model->orderBy($this->orderBy[0],$this->orderBy[1])->Hotels();

        $rows = $rows->get();

        if($this->request->ajax())
            return response()->json($this->view('loop',['rows'=>$rows,
                                                        'columns'=>$this->show_columns_html,
                                                        'select_columns'=>$this->show_columns_select])->render());

        return $this->view('index',array('rows'=>$rows,
            'columns' => $this->show_columns_html,
            'breadcrumb' => $this->breadcrumb,
            'select_columns' => $this->show_columns_select
        ));
    }

    public function photos($id)
    {
        $row = $this->model->find($id);
        return $this->view('photos',
            [
                'row' => $row,
                'breadcrumb'=>$this->breadcrumb
            ]);
    }

    public function rooms($id)
    {
        $row = $this->model->find($id);
        return $this->view('rooms',
            [
                'row' => $row,
                'breadcrumb'=>$this->breadcrumb
            ]);
    }

    public function reservations($id)
    {
        $row = $this->model->find($id);
        return $this->view('reservations',
            [
                'row' => $row,
                'breadcrumb'=>$this->breadcrumb
            ]);
    }


    public function onCreate()
    {
        $countries = Country::pluck('name_ar', 'id');
        $cities    = City::pluck('name_ar', 'id');

        view()->share(compact('countries', 'cities'));
    }

    public function onEdit()
    {
        $countries = Country::pluck('name_ar', 'id');
        $cities    = City::pluck('name_ar', 'id');

        view()->share(compact('countries', 'cities'));
    }

    public function isShowed($row)
    {
        $details = $row->detail;
        view()->share(compact('details'));
    }

    /**
     * Before go inside @store method
     * @return avoid
     */
    public function onStore()
    {
        return $this->v([
            'name'       => 'required|max:255',
            'address'    => 'max:255',
            'email'      => 'required|email|max:255|unique:users',
            'phone'      => 'required|max:255|unique:users',
            'password'   => 'required|min:6',
            'image'      => 'image',
        ]);
    }

    /**
    * Before go inside @update method
    * @return avoid
    */
   public function onUpdate()
    {
       return $this->v([
            'name'       => 'required|max:255',
            'address'    => 'max:255',
            'email'      => 'required|email|max:255|unique:users,email,'.request()->route('hotel'),
            'phone'      => 'required|max:255|unique:users,phone,'.request()->route('hotel'),
            'password'   => 'min:6',
            'image'      => 'image',
        ]);
    }


    public function updateStatus($id)
    {
        $hotel = Hotel::find($id);
        $hotel->update(request(['activation']));

        // $this->sendMail($hotel);

        return back()->with('success', 'Account activation updated successfully');
    }

    public function sendMail($hotel)
    {
        if ($hotel->activation == 1) {
            $hotel->notify(new HotelActivated);
        }
    }

}
