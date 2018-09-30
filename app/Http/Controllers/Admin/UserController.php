<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use App\Models\Admin\Country;
use App\Models\Admin\Area;
use App\Models\Admin\Category;
use App\Models\Admin\nationalities;


class UserController extends CoreController
{
    function __construct(User $model)
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

        $rows = $this->model->orderBy($this->orderBy[0],$this->orderBy[1]);

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


    public function onCreate()
    {
        $countries = Country::pluck('name_ar', 'id');
        $categories = Category::pluck('name_ar', 'id');
        $areas    = Area::pluck('name_ar', 'id');
        $nationality    = nationalities::pluck('name_ar', 'id');
        $activation = ['1' => __('lang.active'), '0' => __('lang.in-active')];
        $gender = ['1' => __('lang.male'), '0' => __('lang.female')];
        $account_manger = ['1' => __('lang.Business manager'), '0' => __('lang.Personal')];
        $type = ['2' => __('lang.Government'),'1' => __('lang.Private sector'), '0' => __('lang.Personal')];
        
        view()->share(compact('countries','categories', 'areas','nationality','activation','gender','account_manger','type'));
    }

    public function onEdit()
    {
        $countries = Country::pluck('name_ar', 'id');
        $categories = Category::pluck('name_ar', 'id');
        $areas    = Area::pluck('name_ar', 'id');
        $nationality    = nationalities::pluck('name_ar', 'id');
        $activation = ['1' => __('lang.active'), '0' => __('lang.in-active')];
        $gender = ['1' => __('lang.male'), '0' => __('lang.female')];
        $account_manger = ['1' => __('lang.Business manager'), '0' => __('lang.Personal')];
        $type = ['2' => __('lang.Government'),'1' => __('lang.Private sector'), '0' => __('lang.Personal')];
        
        view()->share(compact('countries','categories', 'areas','nationality','activation','gender','account_manger','type'));
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
            'email'      => 'required|email|max:255|unique:users,email,'.request()->route('user'),
            'phone'      => 'required|max:255|unique:users,phone,'.request()->route('user'),
            'password'   => 'min:6',
            'image'      => 'image',
        ]);
    }

   // $reservations = Reservations::whereIn('id', $row->reservations)->get();

}
