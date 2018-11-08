<?php

namespace App\Http\Controllers\Admin;

use App\AppBankAccounts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BankAccounts\EditBankAccountsRequest;
use App\Http\Requests\Admin\BankAccounts\StoreBankAccountsRequest;
use Illuminate\Http\Request;

class AppBankAccountsController extends Controller
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
        $list = AppBankAccounts::latest()->paginate(10);
        return view('admin.App_bank_accounts.index',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function search( Request $request )
    {
        //dd(10);
        $query =  $request->q;
        //dd(10);
        
        if ( $query == "") {
            return redirect()->back();
        }else{
             $list   = AppBankAccounts::where('name', 'LIKE', '%' . $query. '%')
                                     
                                     ->orWhere('name_ar', 'LIKE', '%' . $query. '%')
                                     ->orWhere('IBAN', 'LIKE', '%' . $query. '%')
                                     ->orWhere('account_number', 'LIKE', '%' . $query. '%')
                                     ->paginate(10);
            $list->appends( ['q' => $request->q] );
            if (count ( $list ) > 0){
                return view('admin.App_bank_accounts.index',[ 'list' => $list ])->withQuery($query);
            }else{
                return view('admin.App_bank_accounts.index',[ 'list'=>null ,'message' => __('admin.no_result') ]);
            }
        }
    }

    public function create()
    {
        //
        return view('admin.App_bank_accounts.create');
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
        $row = AppBankAccounts::find($id);
        return view('admin.App_bank_accounts.show',compact('row'));
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
        $row = AppBankAccounts::find($id);
        return view('admin.App_bank_accounts.edit',compact('row'));
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
            AppBankAccounts::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }
}
