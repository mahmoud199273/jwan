<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Office\EditOfficeRequest;
use App\Http\Requests\Admin\Office\StoreOfficeRequest;
use App\User;
use Illuminate\Http\Request;


class OfficeController extends Controller
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
        $offices = User::where('type','office')->latest()->paginate(10);
        return view('admin.offices.index',compact('offices'));
    }

    public function search( Request $request )
    {
        $query =  $request->q;
        
        if ( $query == "") {
            return redirect()->back();
        }else{
             $offices   = User::where([['name', 'LIKE', '%' . $query. '%'],['type','office']] )
                                     ->orWhere([['phone', 'LIKE', '%' . $query. '%'],['type','office']] )
                                     ->paginate(10);
            $offices->appends( ['q' => $request->q] );
            if (count ( $offices ) > 0){
                return view('admin.offices.index',[ 'offices' => $offices ])->withQuery($query);
            }else{
                return view('admin.offices.index',[ 'offices'=>null ,'message' => __('admin.no_result') ]);
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
        return view('admin.offices.create',compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfficeRequest $request)
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
        $cities =  City::all();
        $office = User::find($id);
        return view('admin.offices.show',compact('office','cities'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $office = User::find($id);
        $cities =  City::all();

        return view('admin.offices.edit',compact('office','cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditOfficeRequest $request, $id)
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
            User::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }


    public function activate( Request $request)
    {
        if ( $request->ajax() ) {
            $office = User::find( $request->id );
            $office->is_active = '1';
            $office->save();
            return response(['msg' => 'activated', 'status' => 'success']);
        }

        
    }

    public function ban( Request $request )
    {
        $office =  User::find( $request->id );
        if ( $request->ajax() ) {
            $office->is_active = '0';
            $office->save();
            return response(['msg' => 'banned', 'status' => 'success']);
        }

    }


    public function approve( Request $request)
    {
        if ( $request->ajax() ) {
            $office = User::find( $request->id );
            $office->is_approved = '1';
            $office->save();
            return response(['msg' => 'activated', 'status' => 'success']);
        }

        
    }

    public function reject( Request $request )
    {
        $office =  User::find( $request->id );
        if ( $request->ajax() ) {
            $office->is_approved = '0';
            $office->save();
            return response(['msg' => 'banned', 'status' => 'success']);
        }

    }
}
