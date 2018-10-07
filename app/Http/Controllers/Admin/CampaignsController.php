<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
//use App\Http\Requests\Admin\Complaints\StoreComplaintRequest;
//use App\Http\Requests\Admin\Complaints\EditComplaintRequest;
use App\Models\Admin\Campaign;
use Illuminate\Http\Request;


class campaignsController extends Controller
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
        
        $campaigns = Campaign::latest()->paginate(10);
        return view('admin.campaigns.index',compact('campaigns'));
    }


     public function search( Request $request )
    {
        $query =  $request->q;
        if ( $query == "") {
            return redirect()->back();
        }else{
             $campaigns   = Campaign::where('title', 'LIKE', '%' . $query. '%' )
                                     ->paginate(10);
            $campaigns->appends( ['q' => $request->q] );
            if (count ( $campaigns ) > 0){
                return view('admin.campaigns.index',[ 'campaigns' => $campaigns ])->withQuery($query);
            }else{
                return view('admin.campaigns.index',[ 'campaigns'=> null ,'message' => __('admin.no_result') ]);
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
    // public function store(StoreComplaintRequest $request)
    // {
    //     $request->persist();
    //     return redirect()->back()->with('status' , __('admin.created') );

    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campaign = Campaign::find($id);
        return view('admin.campaigns.show',compact('campaign'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $campaign = Campaign::find($id);
        return view('admin.campaigns.edit',compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(EditComplaintRequest $request, $id)
    // {
    //     $request->persist($id);
    //     return redirect()->back()->with('status' , __('admin.updated') );
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            Campaign::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }


  
}
