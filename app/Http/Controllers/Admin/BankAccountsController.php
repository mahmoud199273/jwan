<?php

namespace App\Http\Controllers\Admin;

use App\BankAccounts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BankAccounts\EditBankAccountsRequest;
use App\Http\Requests\Admin\BankAccounts\StoreBankAccountsRequest;
use Illuminate\Http\Request;

class BankAccountsController extends Controller
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
        $list = BankAccounts::select('bank_accounts.*','users.name','banks.name_ar')->join('users','users.id','bank_accounts.user_id')
               ->join('banks','banks.id','bank_accounts.bank_id')
               ->latest()->paginate(10);
        return view('admin.bank_accounts.index',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.bank_accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBankAccountsRequest $request)
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
        $row = BankAccounts::select('bank_accounts.*','users.name','banks.name_ar')->join('users','users.id','bank_accounts.user_id')
               ->join('banks','banks.id','bank_accounts.bank_id')
               ->where('bank_accounts.id',$id)
               ->first();
        return view('admin.bank_accounts.show',compact('row'));
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
        $row = BankAccounts::find($id);
        return view('admin.bank_accounts.edit',compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditBankAccountsRequest $request, $id)
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
        //
        if ($request->ajax()) {
            BankAccounts::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }
}
