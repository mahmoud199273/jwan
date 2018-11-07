<?php

namespace App\Http\Controllers\Admin;

use App\Area;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Areas\EditAreaRequest;
use App\Http\Requests\Admin\Areas\StoreAreaRequest;

use App\Models\Admin\Country;
use Illuminate\Http\Request;


class AreasController extends Controller
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
        
        $areas = Area::latest()->paginate(10);
        return view('admin.areas.index',compact('areas'));
    }


     public function search( Request $request )
    {
        $query =  $request->q;
        if ( $query == "") {
            return redirect()->back();
        }else{
             $areas   = Area::where('name', 'LIKE', '%' . $query. '%' )
                                     ->orWhere('name_ar','LIKE','%'.$query.'%')
                                     ->paginate(10);
            $areas->appends( ['q' => $request->q] );
            if (count ( $areas ) > 0){
                return view('admin.areas.index',[ 'areas' => $areas ])->withQuery($query);
            }else{
                return view('admin.areas.index',[ 'areas'=> null ,'message' => __('admin.no_result') ]);
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
        $countries =  Country::all();
        return view('admin.areas.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAreaRequest $request)
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
        $area = Area::find($id);
        $countries =  Country::all();
        return view('admin.areas.show',compact('area','countries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $area = Area::find($id);
        $countries =  Country::all();
        return view('admin.areas.edit',compact('area','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditAreaRequest $request, $id)
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
            Area::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }


  
}
