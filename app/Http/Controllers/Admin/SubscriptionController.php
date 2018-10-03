<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Notification;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;


class SubscriptionController extends Controller
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
        $subscriptions = Subscription::latest()->paginate(10);
        return view('admin.subscriptions.index',compact('subscriptions'));
    }


    public function search( Request $request )
    {
        $query =  $request->q;
        
        if ( $query == "") {
            return redirect()->back();
        }else{
             $subscriptions   = Subscription::where('user_name', 'LIKE', '%' . $query. '%' )
                                    ->orWhere('transaction_number','LIKE', '%' . $query. '%')
                                    ->orWhere('transaction_date','LIKE', '%' . $query. '%')
                                     ->paginate(10);
            $subscriptions->appends( ['q' => $request->q] );
            if (count ( $subscriptions ) > 0){
                return view('admin.subscriptions.index',[ 'subscriptions' => $subscriptions ])->withQuery($query);
            }else{
                return view('admin.subscriptions.index',[ 'subscriptions'=>null ,'message' => __('admin.no_result') ]);
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subscription = Subscription::find($id);
        return view('admin.subscriptions.show',compact('subscription'));
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
            Subscription::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }


    public function activate( Request $request)
    {
        if ( $request->ajax() ) {
            $subscription = Subscription::find( $request->id );
            $now = Carbon::now();
            $started_at = $now->toDateTimeString();
            $expired_at = $now->addMonths($subscription->package->period)->ToDateTimeString();
            $subscription->is_approved = '1';
            $subscription->started_at = $started_at;
            $subscription->expired_at = $expired_at ;
            $subscription->save();
            $user = $subscription->user;
             Notification::create(['user_id' => $user->id , 'title'=> 'تم تفيل باقة الاشتراك بنجاح ', 'body' =>  'تم تفيل باقة الاشتراك بنجاح '.$subscription->package->name ]);
            if ($user->player_id != null) {
                @sendNotification('تم تفيل باقة الاشتراك بنجاح ',(array) $user->player_id , ['foo' => 'bar']);
            }
            return response(['msg' => 'activated', 'status' => 'success']);
        }

        
    }

    public function ban( Request $request )
    {
        $subscription =  Subscription::find( $request->id );
        if ( $request->ajax() ) {
            $subscription->is_approved = '0';
            $subscription->save();
            return response(['msg' => 'banned', 'status' => 'success']);
        }

    }
}
