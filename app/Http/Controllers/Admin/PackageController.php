<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Package\EditPackageRequest;
use App\Http\Requests\Admin\Package\StorePackageRequest;
use App\Package;
use Illuminate\Http\Request;


class PackageController extends Controller
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
        $packages = Package::latest()->paginate(10);
        return view('admin.packages.index',compact('packages'));
    }

     public function search( Request $request )
    {
        $query =  $request->q;
        
        if ( $query == "") {
            return redirect()->back();
        }else{
             $packages  = Package::where('title', 'LIKE', '%' . $query. '%' )
                                     ->paginate(10);
            $packages->appends( ['q' => $request->q] );
            if (count ( $packages) > 0){
                return view('admin.packages.index',[ 'packages' => $packages])->withQuery($query);
            }else{
                return view('admin.packages.index',[ 'packages'=>null ,'message' => __('admin.no_result') ]);
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
        return view('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePackageRequest $request)
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
        $package = Package::find($id);
        return view('admin.packages.show',compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package = Package::find($id);
        return view('admin.packages.edit',compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditPackageRequest $request, $id)
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
            Package::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }


    public function activate( Request $request)
    {
        if ( $request->ajax() ) {
            $package = Package::find( $request->id );
            $package->is_active = '1';
            $package->save();
            return response(['msg' => 'activated', 'status' => 'success']);
        }

        
    }

    public function ban( Request $request )
    {
        $package =  Package::find( $request->id );
        if ( $request->ajax() ) {
            $package->is_active = '0';
            $package->save();
            return response(['msg' => 'banned', 'status' => 'success']);
        }

    }
}
