<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BankAccounts\EditTransactionsRequest;
use App\Http\Requests\Admin\BankAccounts\StoreTransactionsRequest;
use App\Transactions;
use App\UserPlayerId;
use App\User;
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

    public function userTransactions(Request  $request  ,$id)
    {
        $list = Transactions::where('user_id',$id)->latest()->paginate(10);
         return view('admin.transactions.index',compact('list'));
    }
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
            //dd($query);
             $list   = Transactions::join('users','users.id','=','transactions.user_id')
             ->leftjoin('campaigns','campaigns.id','=','transactions.campaign_id')
             ->leftjoin('offers','offers.id','=','transactions.offer_id')
             ->where('users.name', 'LIKE', '%' . $query. '%')
                                     
                                     ->orWhere('campaigns.title', 'LIKE', '%' . $query. '%')
                                     ->orWhere('offers.cost', 'LIKE', '%' . $query. '%')
                                     ->orWhere('transactions.amount', 'LIKE', '%' . $query. '%')
                                     ->orWhere('transactions.direction', 'LIKE', '%' . $query. '%')
                                     ->orWhere('transactions.transaction_bank_name', 'LIKE', '%' . $query. '%')
                                     ->orWhere('transactions.transaction_account_name', 'LIKE', '%' . $query. '%')
                                     ->orWhere('transactions.transaction_account_number', 'LIKE', '%' . $query. '%')
                                     ->orWhere('transactions.transaction_number', 'LIKE', '%' . $query. '%')
                                     //->orWhere('convert(transactions.transaction_date , utf8)', 'LIKE', '%' . $query. '%')
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


    // public function create()
    // {
    //     //
    //     return view('admin.bank_accounts.create');
    // }

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
            $transaction->status = $request->status;
            $transaction->save();

            $TransactionData = Transactions::select('users.*','transactions.*','campaigns.title','uinf.id as influencer_id','uuser.id as offer_user_id')
                                            ->join('users','users.id','transactions.user_id')
                                            ->leftJoin('campaigns', 'campaigns.id', '=', 'transactions.campaign_id')
                                            ->leftJoin('offers', 'offers.id', '=', 'transactions.offer_id')
                                            ->leftJoin('users as uinf', 'offers.influncer_id', '=', 'uinf.id')
                                            ->leftJoin('users as uuser', 'offers.user_id', '=', 'uuser.id')
                                            ->where('transactions.id','23')
                                            //->where('transactions.id',$request->id)
                                            ->first();

            
            if($TransactionData->account_type == 0 && $request->status == 1 && $TransactionData->campaign_id == 0 && $TransactionData->offer_id == 0)
            {
                $user = User::find($TransactionData->user_id);
                $user->balance = $user->balance + $TransactionData->transaction_amount;
                //dd($user->balance);
                $user->save();
            }
            elseif($TransactionData->account_type == 1 && $request->status == 1 && $TransactionData->campaign_id == 0 && $TransactionData->offer_id == 0)
            {
                $user = User::find($TransactionData->user_id);
                $user->balance = $user->balance - $TransactionData->transaction_amount;
                //dd($user->balance);
                $user->save();
            }

            if($TransactionData->influencer_id) // send notification to influencer if transaction has offer id
            {
                $player_ids = $this->getUserPlayerIds($TransactionData->influencer_id);
                sendNotification(1,
                                  'Your transaction approved',
                                  'تم الموافقة على عملية التحويل ',
                                  $player_ids,"offers",
                                  ['transaction_id' =>  (int)$TransactionData->id,
                                  'offer_id'    => (int)$TransactionData->offer_id,
                                  'campaign_id'    => (int)$TransactionData->campaign_id,
                                  'type'          =>  1,
                                  'type_title'	=> 'transaction approve']);

            }


            if($TransactionData->offer_user_id){ // send notification to user 
                $noti_user_id = $TransactionData->offer_user_id;
                $account_type = 0; //send notification to user 
            } 
            else 
            {
                $noti_user_id = $TransactionData->user_id;
                $account_type = $TransactionData->account_type; // send notification to user or influencer
            }         
            
            $player_ids = $this->getUserPlayerIds($noti_user_id);
            sendNotification($account_type,
                                'Your transaction approved',
                                'تم الموافقة على عملية التحويل ',
                                $player_ids,"offers",
                                ['transaction_id' =>  (int)$TransactionData->id,
                                'offer_id'    => (int)$TransactionData->offer_id,
                                'campaign_id'    => (int)$TransactionData->campaign_id,
                                'type'          =>  1,
                                'type_title'	=> 'transaction approve']);

                                  
            
            return response(['msg' => 'approved', 'status' => 'success']);
        }

        
    }


    public function getUserPlayerIds( $user_id )
    {
        $player_ids = UserPlayerId::where('user_id',$user_id)->pluck('player_id')->toArray();
        return $player_ids ? $player_ids : null;
    }

}
