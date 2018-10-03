<?php

namespace App\Http\Controllers\Admin;

use App\Ad;
use App\AdImage;
use App\AdProperty;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ad\EditAdRequest;
use App\Http\Requests\Admin\Ad\StoreAdRequest;
use App\Transformers\AdTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class adController extends Controller
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
        $ads = Ad::latest()->paginate(10);
        return view('admin.ads.index',compact('ads'));
    }

    public function search( Request $request )
    {
        $query =  $request->q;
        
        if ( $query == "") {
            return redirect()->back();
        }else{
             $ads   = Ad::where('title', 'LIKE', '%' . $query. '%' )
                                     ->orWhere( 'price', 'LIKE', '%' . $query. '%' )
                                     ->paginate(10);
            $ads->appends( ['q' => $request->q] );
            if (count ( $ads ) > 0){
                return view('admin.ads.index',[ 'ads' => $ads ])->withQuery($query);
            }else{
                return view('admin.ads.index',[ 'ads'=>null ,'message' => __('admin.no_result') ]);
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
        return view('admin.ads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdRequest $request)
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
    public function show($id, AdTransformer $adTransformer)
    {
        $ad = $adTransformer->transform(Ad::find($id));
        $property_types = DB::table('property_types')->get();
        $cities         = DB::table('cities')->get();
        $districts      = DB::table('districts')->get();
        return view('admin.ads.show',compact('ad','property_types','cities','districts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, AdTransformer $adTransformer)
    {
        $ad = $adTransformer->transform(Ad::find($id));
        $property_types = DB::table('property_types')->get();
        $cities         = DB::table('cities')->get();
        $districts      = DB::table('districts')->get();
        return view('admin.ads.edit',compact('ad','property_types','cities','districts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $validator = Validator::make($request->all() , [
            'title'                 => 'required',
            'price'                 => 'required|string',
            'detailed_address'      => 'required', 
            'contract_type'         => ['required', Rule::in(['sale','rent'])],
            'description'           => 'nullable|string',
            'contract_image'        => 'nullable|mimes:jpg,png,jpeg',
            'city'                  => 'required',
            // 'area'                  => 'required',
            'size'                  => 'required',
            'contact_time'          => 'required',
            'contact_phone'        => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }

        $ad = Ad::find($id);
        $ad->title                      = $request->title;
        $ad->price                      = $request->price;
        $ad->description                = $request->description;
        $ad->city                       = $request->city;
        $ad->area                       = $request->area;
        $ad->city_id                    = $request->city;
        $ad->district_id                = $request->area;
        $ad->detailed_address           = $request->detailed_address;
        $ad->lat                        =  $request->lat;
        $ad->lng                        =  $request->lng;
        $ad->type                       =  $request->property_type;
        $ad->contract_type              =  $request->contract_type;
        $ad->contact_phone              =  $request->contact_phone;
        $ad->contact_time               =  $request->contact_time;
        $ad->size                       =  $request->size;
        $ad->rent_period                =  ($request->rent_period) ? $request->rent_period : '1';
    
        if ($request->contract_image) {
            $ad->contract_image  = $this->uploadFile($request->contract_image);
        }

        $ad->save();

        $property_attributes = $request->all();
        $property_attributes['ad_id'] = $ad->id;
        $property_attributes['type'] = $ad->type;
        AdProperty::where('ad_id' ,$ad->id)->delete();
        AdProperty::create($property_attributes);
        if ($request->allimages) {
           foreach ($request->allimages as $image) {
                $images = [];
                $images['ad_id'] = $ad->id;
                $images['image'] = $image;
                AdImage::create($images);
            } 
        }
        
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
            Ad::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }


    public function activate( Request $request)
    {
        if ( $request->ajax() ) {
            $ad = Ad::find( $request->id );
            $ad->is_active = '1';
            $ad->save();
            return response(['msg' => 'activated', 'status' => 'success']);
        }

        
    }

    public function ban( Request $request )
    {
        $ad =  Ad::find( $request->id );
        if ( $request->ajax() ) {
            $ad->is_active = '0';
            $ad->save();
            return response(['msg' => 'banned', 'status' => 'success']);
        }

    }

    public function removeAdImage(Request $request, $id)
    {

        if ($request->ajax()) {
            $img = AdImage::find($id);
            $images = AdImage::where('ad_id',$img->ad_id)->count();
            if ($images <= 1) {
                return response(['msg' => 'not_deleted', 'status' => 'error']);
            }else{
                $img->delete();
            }
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }
}
