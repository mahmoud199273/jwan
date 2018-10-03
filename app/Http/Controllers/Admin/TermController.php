<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Term\EditTermRequest;
use App\Http\Requests\Admin\Term\StoreTermRequest;
use App\Term;
use Illuminate\Http\Request;


class TermController extends Controller
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
        $terms = Term::latest()->paginate(10);
        return view('admin.terms.index',compact('terms'));
    }

    public function search( Request $request )
    {
        $query =  $request->q;
        
        if ( $query == "") {
            return redirect()->back();
        }else{
             $terms   = Term::where('term', 'LIKE', '%' . $query. '%' )
                                     ->paginate(10);
            $terms->appends( ['q' => $request->q] );
            if (count ( $terms ) > 0){
                return view('admin.terms.index',[ 'terms' => $terms ])->withQuery($query);
            }else{
                return view('admin.terms.index',[ 'terms'=>null ,'message' => __('admin.no_result') ]);
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
        return view('admin.terms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTermRequest $request)
    {
        $request->persist();
        return redirect()->back()->with('status' , __('admin.created') );

    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     $faq = Faq::find($id);
    //     return view('admin.terms.show',compact('faq'));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $term = Term::find($id);
        return view('admin.terms.edit',compact('term'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditTermRequest $request, $id)
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
            Term::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }


}
