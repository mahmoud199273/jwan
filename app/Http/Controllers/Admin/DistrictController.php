<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\District;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Districts\EditDistrictRequest;
use App\Http\Requests\Admin\Districts\StoreDistrictRequest;
use Illuminate\Http\Request;


class DistrictController extends Controller
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
        $districts = District::latest()->paginate(10);
        return view('admin.districts.index',compact('districts'));
    }



     public function search( Request $request )
    {
        $query =  $request->q;
        if ( $query == "") {
            return redirect()->back();
        }else{
             $districts   = District::where('name', 'LIKE', '%' . $query. '%' )
                                     ->paginate(10);
            $districts->appends( ['q' => $request->q] );
            if (count ( $districts ) > 0){
                return view('admin.districts.index',[ 'districts' => $districts ])->withQuery($query);
            }else{
                return view('admin.districts.index',[ 'districts' =>null ,'message' => __('admin.no_result') ]);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities =  City::all();
        return view('admin.districts.create',compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDistrictRequest $request)
    {
        $request->persist();
        return redirect()->back()->with('status' , __('admin.created') );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $district = District::find($id);
        return view('admin.districts.show',compact('district'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $district = District::find($id);
        $cities =  City::all();
        return view('admin.districts.edit',compact('district','cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditDistrictRequest $request, $id)
    {
        $request->persist($id);
        return redirect()->back()->with('status' , __('admin.updated') );
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
            District::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }


  
}
