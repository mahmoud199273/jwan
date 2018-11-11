<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pages\StorePageRequest;
use App\Http\Requests\Admin\Pages\EditPageRequest;
use App\Pages;
use Illuminate\Http\Request;


class PagesController extends Controller
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
        //
        $pages = Pages::latest()->paginate(10);
        return view('admin.pages.index',compact('pages'));
    }

    
     public function search( Request $request )
    {
        //dd(10);
        $query =  $request->q;
        if ( $query == "") {
            return redirect()->back();
        }else{
             $pages   = Pages::where('name_ar', 'LIKE', '%' . $query. '%' )
                                     ->orWhere('name','LIKE','%'.$query.'%')
                                     ->orWhere('desc','LIKE','%'.$query.'%')
                                     ->orWhere('desc_ar','LIKE','%'.$query.'%')
                                     ->paginate(10);
            $pages->appends( ['q' => $request->q] );
            if (count ( $pages ) > 0){
                return view('admin.pages.index',[ 'pages' => $pages ])->withQuery($query);
            }else{
                return view('admin.pages.index',[ 'pages'=> null ,'message' => __('admin.no_result') ]);
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
        //
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePageRequest $request)
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
        //
        $page = Pages::find($id);
        return view('admin.pages.show',compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $page = Pages::find($id);
        return view('admin.pages.edit',compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditPageRequest $request, $id)
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
    public function destroy($id)
    {
        //
    }
}
