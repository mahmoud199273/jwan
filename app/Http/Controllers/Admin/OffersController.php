<?php

namespace App\Http\Controllers\Admin;

use App\Offer;
use App\User;
use App\Campaign;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Offer\EditOfferRequest;
use Illuminate\Http\Request;


class OffersController extends Controller
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
        $offers = Offer::latest()->paginate(10);
        return view('admin.offers.index',compact('offers'));
    }
    

    function campaigns(Request $request , $id)
    {
        $offers = Offer::where('campaign_id',$id)->latest()->paginate(10);
        return view('admin.offers.index',compact('offers'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offer = Offer::find($id);
        return view('admin.offers.show',compact('offer'));   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $offer = Offer::find($id);
        $users =  User::where('account_type','0')->get();
        $influncers =  User::where('account_type','1')->get();
        $campaigns =  Campaign::all();
        return view('admin.offers.edit',compact('offer','users','influncers','campaigns'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditOfferRequest $request, $id)
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
            Offer::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }


  
}
