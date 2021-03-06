<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Services\StoreServicesRequest;
use App\Http\Requests\Admin\Services\EditServicesRequest;
use App\Services;
use Illuminate\Http\Request;


class ServicesController extends Controller
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
        $services = Services::latest()->paginate(10);
        return view('admin.services.index',compact('services'));
    }



    public function search( Request $request )
    {
        $query =  $request->q;
        if ( $query == "") {
            return redirect()->back();
        }else{
             $services   = Services::where('title', 'LIKE', '%' . $query. '%' )
                                ->orWhere('body','LIKE', '%' . $query. '%' )
                                     ->paginate(10);
            $services->appends( ['q' => $request->q] );
            if (count ( $services ) > 0){
                return view('admin.services.index',[ 'services' => $services ])->withQuery($query);
            }else{
                return view('admin.services.index',[ 'services'=>null ,'message' => __('admin.no_result') ]);
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
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServicesRequest $request)
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
        $services = Services::find($id);
        return view('admin.services.show',compact('services'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $services = Services::find($id);
        return view('admin.services.edit',compact('services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditServicesRequest $request, $id)
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
            Services::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }


  
}
