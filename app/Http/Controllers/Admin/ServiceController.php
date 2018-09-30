<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Services\Service;
use App\Http\Controllers\Controller;
use App\Models\Services\ServiceOptions;

class ServiceController extends CoreController
{
    function __construct(Service $model)
    {
        $this->model = $model;
        $this->show_columns_select = array('id','name_ar','name_en');
        $this->show_columns_html = array('id','name_ar','name_en');
        parent::__construct();
    }

    public function onStore()
    {
        return $this->v([
            'name_ar' => 'required|max:255|unique:services',
            'name_en' => 'required|max:255|unique:services',
        ]);
    }

    public function isStored($row)
    {
        foreach (request('option_en') as $key => $option) {
            if (!empty(request('option_ar')[$key]) && !empty(request('option_ar')[$key]) ) {
                $row->options()->create(
                    [
                        'name_ar'=>request('option_ar')[$key],
                        'name_en'=>request('option_en')[$key],
                        'image'=>request('image')[$key]
                    ]
                );
            }

        }
    }




   public function onUpdate()
    {
       return $this->v([
            'name_ar' => 'required|max:255|unique:services,name_ar,'.request()->route('service'),
            'name_en' => 'required|max:255|unique:services,name_en,'.request()->route('service'),
        ]);
    }

    public function isUpdated($row)
    {
        foreach (request('option_id') as $key => $option) {
                if (!empty(request('option_ar')[$key]) && !empty(request('option_ar')[$key]) ) {
                    if (!empty($option))
                    {
                        $row->options()->find($option)->update(
                            [
                                'name_ar'=>request('option_ar')[$key],
                                'name_en'=>request('option_en')[$key],
                                'image'=>request('image')[$key]
                            ]
                        );
                    }
                    //create
                    else {
                        $row->options()->create(
                            [
                                'name_ar'=>request('option_ar')[$key],
                                'name_en'=>request('option_en')[$key],
                                'image'=>request('image')[$key]
                            ]
                        );
                    }

                }



        }




    }


    public function destroyOption($id)
    {
        ServiceOptions::destroy($id);
        return response()->json(['status'=>true]);
    }
}
