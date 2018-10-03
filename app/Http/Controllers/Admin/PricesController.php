<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Prices\EditPriceRequest;
use App\Http\Requests\Admin\Prices\StorePriceRequest;
use App\PriceGuide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PricesController extends Controller
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
        $prices = priceGuide::latest()->paginate(10);
        return view('admin.prices.index',compact('prices'));
    }


    public function search( Request $request )
    {
        $query =  $request->q;
         if (in_array($query,property_types())) {
             $query = array_search($query,property_types());
         }else{
             $query = $request->q;
         }
         
        if ( $query == "") {
            return redirect()->back();
        }else{
             $prices   = PriceGuide::where('type', 'LIKE', '%' . $query. '%' )
                                     ->paginate(10);
            $prices->appends( ['q' => $request->q] );
            if (count ( $prices ) > 0){
                return view('admin.prices.index',[ 'prices' => $prices ])->withQuery($query);
            }else{
                return view('admin.prices.index',[ 'prices'=>null ,'message' => __('admin.no_result') ]);
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
        $property_types = DB::table('property_types')->get();
        $cities         = DB::table('cities')->get();
        $districts      = DB::table('districts')->get();
        return view('admin.prices.create',compact('cities','property_types','districts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePriceRequest $request)
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
        $price = price::find($id);
        return view('admin.prices.show',compact('price'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $price = priceGuide::find($id);
        $property_types = DB::table('property_types')->get();
        $cities         = DB::table('cities')->get();
        $districts      = DB::table('districts')->get();
        return view('admin.prices.edit',compact('price','cities','property_types','districts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditPriceRequest $request, $id)
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
            priceGuide::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }




}
