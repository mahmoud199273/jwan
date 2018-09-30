<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservations;
use App\Models\Admin;
use App\Models\Permission\Role;

class AdminController extends CoreController
{
    function __construct(Admin $model)
    {
        $this->model = $model;
        $this->show_columns_html = array('id','name','email','created_at');
        $this->show_columns_select = array('id','name','email','created_at');
        parent::__construct();
    }

    /**
     * Form Builder
     * @return Array
     */
    public function formBuilder()
    {
        $roles_lists = Role::pluck('title','id');

         $this->formInput =
        [
            [
                'name'=>'name',
                'label'=>trans('lang.name'),
                'type'=>'text',
                'value'=>null,
                'options'=>
                [
                    'id'=>'name',
                    'class'=>'form-control'
                ],
                'wrap_class'=>'col-md-6'
            ],

            [
                'name'=>'email',
                'label'=>trans('lang.email'),
                'type'=>'text',
                'value'=>null,
                'options'=>
                [
                    'id'=>'email',
                    'class'=>'form-control'
                ],
                'wrap_class'=>'col-md-6'
            ],


            [
                'name'=>'image',
                'label'=>trans('lang.image'),
                'type'=>'file',
                'value'=>null,
                'options'=>
                [
                    'id'=>'image',
                    'class'=>'form-control'
                ],
                'wrap_class'=>'col-md-12'
            ],



            [
                'name'=>'password',
                'label'=>trans('lang.password'),
                'type'=>'password',
                'value'=>null,
                'options'=>
                [
                    'id'=>'password',
                    'class'=>'form-control'
                ],
                'wrap_class'=>'col-md-12'
            ],



            [
                'name'=>'activation',
                'label'=>trans('lang.activation'),
                'type'=>'select',
                'select_options'=>[1=>trans('lang.active'),0=>trans('lang.deactivate')],
                'value'=>null,
                'options'=>
                [
                    'id'=>'activation',
                    'class'=>'form-control'
                ],
                'wrap_class'=>'col-md-6'
            ],

             [
                'name'=>'role_id',
                'label'=>trans('lang.role_id'),
                'type'=>'select',
                'select_options'=>$roles_lists,
                'value'=>null,
                'options'=>
                [
                    'id'=>'role_id',
                    'class'=>'form-control',
                    'placeholder'=>'Set Role for this user'
                ],
                'wrap_class'=>'col-md-6'
            ],



        ];
    }

    /**
     * Before go inside @index method
     * @return avoid
     */
    public function onIndex()
    {
        $this->escape_columns = ['posts'];
        $this->custom_columns = [
           /* [
                'name'=>'posts_count','value'=>function($row){
                   return $row->posts()->count();
                }
            ]*/
        ];

        $this->add_columns = [
            /*[
                'name'=>'posts_count','value'=>function($row){
                   return $row->posts()->count();
                }
            ]*/

           /* [
                'name'=>'new_attr','value'=> function($row){
                   return  "name : $row->name || email : $row->email";
                }
            ],

            [
                'name'=>'new_attr2','value'=> function($row){
                   return  "name : $row->name || age : 2";
                }
            ],*/

        ];


    }

    /**
     * Your custom query to show data in index
     * @return json Instance OF $this->model
     */
    public function builder()
    {
        return $this->model->select($this->show_columns_select);
    }

    /**
     * Before go inside @store method
     * @return avoid
     */
    public function onStore()
    {
        return $this->v([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'image' => 'image',
            'password' => 'min:6',
            'activation'=>'required|boolean'
        ]);
    }

    /**
    * Before go inside @update method
    * @return avoid
    */
   public function onUpdate()
    {
       return $this->v([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.request()->route('user'),
            'image' => 'image',
            'password' => 'min:6',
            'activation'=>'required|boolean'
            ]);
    }

    // $reservations = Reservations::whereIn('id', $row->reservations)->get();

}
