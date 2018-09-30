<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ContactUs;
use Illuminate\Http\Request;


class ContactUsController extends Controller
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
        $messages = ContactUs::paginate();
        return view('admin.contact_us.index',compact('messages'));
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message = ContactUs::find($id);
        return view('admin.contact_us.show',compact('message'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            ContactUs::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }


  
}
