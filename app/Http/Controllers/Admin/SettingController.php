<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\PropertyType;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class SettingController extends Controller
{

    function __construct(){
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first();
        return view('admin.setting.edit',compact('setting'));
    }

    
    public function update(Request $request, $id)
    {
        $requestData =  $request->all();
        unset($requestData['_token']);
        if ($request->home_image) {
            $requestData['homa_image'] =  $this->uploadFile($request->home_image);
        }
        $setting = Setting::find($id)->update($requestData);
        return redirect()->back()->with('status' , __('admin.updated') );
    }

    public function properties( Request $request )
    {
        $properties  = DB::table('property_types')->get();
        return view('admin.setting.edit_properties',compact('properties'));
    }

    public function edit( $id )
    {
        $property  = DB::table('property_types')->find($id);
        return view('admin.setting.edit_image',compact('property'));
    }

    public function updateImage( Request $request,$id )
    {
        $validator = Validator::make($request->all() , [
            'icon' => 'required|mimes:jpg,png,jpeg|max:4000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }

        $property  = PropertyType::find($id);
         if ($request->icon) {
            $property->icon =  $this->uploadFile($request->icon);
        }
        $property->save();
        return redirect(config('app.admin_url').'/property/images')->with('status' , __('admin.updated') );
    }
   


 
}
