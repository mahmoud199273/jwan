<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BankAccounts\EditTransactionsRequest;
use App\Http\Requests\Admin\BankAccounts\StoreTransactionsRequest;
use App\Transactions;
use Illuminate\Http\Request;

class TransactionsController extends Controller
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
        //dd("here");
        $list =  Transactions::SELECT('transactions.*','campaigns.title','users.name','offers.cost')
                                    ->leftJoin('users', 'users.id', '=', 'transactions.user_id')
                                    ->leftJoin('campaigns', 'campaigns.id', '=', 'transactions.campaign_id')
                                    ->leftJoin('offers', 'offers.id', '=', 'transactions.offer_id')
                    ->orderBy('transactions.id','DESC')
               ->latest()->paginate(10);
        // $list = Transactions::latest()->paginate(10);
        //        //->join('users','users.id','transactions.user_id')
        //        //->join('campaigns','campaigns.id','transactions.campaign_id')
        // // dd($list);
               

        return view('admin.transactions.index',compact('list'));
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
             $list   = Transactions::join('users','users.id','=','transactions.user_id')
             ->join('campaigns','campaigns.id','=','transactions.campaign_id')
             ->join('offers','offers.id','=','transactions.offer_id')
             ->where('users.name', 'LIKE', '%' . $query. '%')
                                     
                                     ->orWhere('campaigns.title', 'LIKE', '%' . $query. '%')
                                     ->orWhere('offers.cost', 'LIKE', '%' . $query. '%')
                                     ->orWhere('transactions.amount', 'LIKE', '%' . $query. '%')
                                     ->orWhere('transactions.direction', 'LIKE', '%' . $query. '%')
                                     ->orWhere('transactions.transaction_bank_name', 'LIKE', '%' . $query. '%')
                                     ->orWhere('transactions.transaction_account_name', 'LIKE', '%' . $query. '%')
                                     ->orWhere('transactions.transaction_account_number', 'LIKE', '%' . $query. '%')
                                     ->orWhere('transactions.transaction_number', 'LIKE', '%' . $query. '%')
                                     ->orWhere('transactions.transaction_date', 'LIKE', '%' . $query. '%')
                                     ->orWhere('transactions.transaction_amount', 'LIKE', '%' . $query. '%')
                                     // ->orWhere('transactions.type', 'LIKE', '%' . $query. '%')
                                     ->paginate(10);
            $list->appends( ['q' => $request->q] );
            if (count ( $list ) > 0){
                return view('admin.transactions.index',[ 'list' => $list ])->withQuery($query);
            }else{
                return view('admin.transactions.index',[ 'list'=>null ,'message' => __('admin.no_result') ]);
            }
        }
    }


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
    public function store(StoreTransactionsRequest $request)
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
        $row = Transactions::SELECT('transactions.*','campaigns.title','users.name','offers.cost')
                                    ->leftJoin('users', 'users.id', '=', 'transactions.user_id')
                                    ->leftJoin('campaigns', 'campaigns.id', '=', 'transactions.campaign_id')
                                    ->leftJoin('offers', 'offers.id', '=', 'transactions.offer_id')
                    ->orderBy('transactions.id','DESC')
               ->where('transactions.id',$id)
               ->first();
        return view('admin.transactions.show',compact('row'));
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
        $row = Transactions::find($id);
        return view('admin.transactions.edit',compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditTransactionsRequest $request, $id)
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
            Transactions::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }

     public function approve( Request $request)
    {
        if ( $request->ajax() ) {
            $transaction = Transactions::find( $request->id );
            $transaction->status = 1;
            $transaction->save();
            return response(['msg' => 'approved', 'status' => 'success']);
        }

        
    }

}
