<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Http\Requests\Admin\Nathionalities\StoreNathionalityRequest;
use App\Http\Requests\Admin\Nathionalities\EditNathionalityRequest;
use App\Models\Admin\Nathionalities;
use Illuminate\Http\Request;
=======
use App\Models\Admin\nationalities;
>>>>>>> 57a21f079cc8787a516b8b971b392ed25d58305d


class NatoinalityController extends Controller
{
<<<<<<< HEAD

    function __construct(){
        //$this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
=======
    function __construct(nationalities $model)
>>>>>>> 57a21f079cc8787a516b8b971b392ed25d58305d
    {
        
        $rows = Nathionalities::latest()->paginate(10);
        return view('admin.natoinalities.index',compact('rows'));
    }


     public function search( Request $request )
    {
        $query =  $request->q;
        if ( $query == "") {
            return redirect()->back();
        }else{
             $rows   = Nathionalities::where('name', 'LIKE', '%' . $query. '%' )
                                     ->paginate(10);
            $rows->appends( ['q' => $request->q] );
            if (count ( $rows ) > 0){
                return view('admin.natoinalities.index',[ 'rows' => $rows ])->withQuery($query);
            }else{
                return view('admin.natoinalities.index',[ 'rows'=> null ,'message' => __('admin.no_result') ]);
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
        return view('admin.natoinalities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNathionalityRequest $request)
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
        $row = Nathionalities::find($id);
        return view('admin.natoinalities.show',compact('row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Nathionalities::find($id);
        return view('admin.natoinalities.edit',compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditNathionalityRequest $request, $id)
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
            Nathionalities::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }


  
}
