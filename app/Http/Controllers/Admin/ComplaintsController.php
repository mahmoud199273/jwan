<?php

namespace App\Http\Controllers\Admin;

use App\ContactUs;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Complaints\EditComplaintRequest;
use App\Http\Requests\Admin\Complaints\StoreComplaintRequest;
use Illuminate\Http\Request;


class ComplaintsController extends Controller
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
        
        $complaints = ContactUs::join('users','users.id','contact_us.user_id')->latest()->paginate(10);
        return view('admin.contact_us.index',compact('complaints'));
    }


     public function search( Request $request )
    {
        $query =  $request->q;
        if ( $query == "") {
            return redirect()->back();
        }else{
             $complaints   = ContactUs::where('subject', 'LIKE', '%' . $query. '%' )
                                     ->orWhere('user_id','LIKE','%'.$query.'%')
                                     ->orWhere('created_at','LIKE','%'.$query.'%')
                                     ->paginate(10);
            $complaints->appends( ['q' => $request->q] );
            if (count ( $complaints ) > 0){
                return view('admin.contact_us.index',[ 'complaints' => $complaints ])->withQuery($query);
            }else{
                return view('admin.contact_us.index',[ 'complaints'=> null ,'message' => __('admin.no_result') ]);
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
        return view('admin.contact_us.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComplaintRequest $request)
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
        $complaint = ContactUs::find($id);
        return view('admin.contact_us.show',compact('complaint'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $complaint = ContactUs::find($id);
        return view('admin.contact_us.edit',compact('complaint'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditComplaintRequest $request, $id)
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
            ContactUs::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }


  
}
