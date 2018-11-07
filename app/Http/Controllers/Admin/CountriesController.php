<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Countries\EditCountryRequest;
use App\Http\Requests\Admin\Countries\StoreCountryRequest;
use Illuminate\Http\Request;


class CountriesController extends Controller
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
        
        $countries = Country::latest()->paginate(10);
        return view('admin.countries.index',compact('countries'));
    }


     public function search( Request $request )
    {
        //dd(10);
        $query =  $request->q;
        if ( $query == "") {
            return redirect()->back();
        }else{
             $countries   = Country::where('name_ar', 'LIKE', '%' . $query. '%' )
                                     ->orWhere('name','LIKE','%'.$query.'%')
                                     ->orWhere('code','LIKE','%'.$query.'%')
                                     ->paginate(10);
            $countries->appends( ['q' => $request->q] );
            if (count ( $countries ) > 0){
                return view('admin.countries.index',[ 'countries' => $countries ])->withQuery($query);
            }else{
                return view('admin.countries.index',[ 'countries'=> null ,'message' => __('admin.no_result') ]);
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
        return view('admin.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCountryRequest $request)
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
        $country = Country::find($id);
        return view('admin.countries.show',compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = Country::find($id);
        return view('admin.countries.edit',compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditCountryRequest $request, $id)
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
            Country::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }


  
}
