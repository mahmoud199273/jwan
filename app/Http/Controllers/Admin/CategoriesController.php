<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\EditCategoryRequest;
use App\Http\Requests\Admin\Categories\StoreCategoryRequest;

use Illuminate\Http\Request;


class CategoriesController extends Controller
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
        
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index',compact('categories'));
    }


     public function search( Request $request )
    {
        //dd(10);
        $query =  $request->q;
        if ( $query == "") {
            return redirect()->back();
        }else{
             $categories   = Category::where('name', 'LIKE', '%' . $query. '%' )
                                     ->orWhere('name_ar','LIKE','%'.$query.'%')
                                     ->paginate(10);
            $categories->appends( ['q' => $request->q] );
            if (count ( $categories ) > 0){
                return view('admin.categories.index',[ 'categories' => $categories ])->withQuery($query);
            }else{
                return view('admin.categories.index',[ 'categories'=> null ,'message' => __('admin.no_result') ]);
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
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
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
        $category = Category::find($id);
        return view('admin.categories.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditCategoryRequest $request, $id)
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
            Category::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }


  
}
