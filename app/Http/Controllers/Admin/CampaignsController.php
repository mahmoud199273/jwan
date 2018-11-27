<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
//use App\Http\Requests\Admin\Complaints\StoreComplaintRequest;
use App\Http\Requests\Admin\Campaigns\EditCampaignsRequest;
use Illuminate\Support\Facades\DB;
use App\Campaign;
use App\CampaignArea;
use App\CampaignCategory;
use App\CampaignCountry;
use App\User;
use App\Setting;
use App\UserPlayerId;
use Carbon\Carbon;
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

    public function getUserSinglePlayerIds( $user_id )
    {
        $player_ids = UserPlayerId::where('user_id',$user_id)->pluck('player_id')->toArray();
        return $player_ids ? $player_ids : null;
    }

    function testNot()
    {
            $user_player_ids = $this->getUserSinglePlayerIds('272');

            $result = sendNotification(0 ,'Your campaign has been approved','تم الموافقة على عرض الحملة ',$user_player_ids,"public",['campaign_id' =>'2','type' =>  20,'type_title'  => 'new campaign']);
            dd($result);
    }
    public function index()
    {
        $campaigns = Campaign::latest()->paginate(10);
        return view('admin.campaigns.index',compact('campaigns'));
    }


     public function search( Request $request )
    {
        //dd(10);
        $query =  $request->q;
        if ( $query == "") {
            return redirect()->back();
        }else{
             $campaigns   = Campaign::where('title', 'LIKE', '%'.$query.'%' )
                                    ->orWhere('user_id','LIKE','%'.$query.'%')
                                    ->orWhere('created_at','LIKE','%'.$query.'%')
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
        $users =  User::where('account_type','0')->get();
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
        $users =  User::where('account_type','0')->get();
        return view('admin.campaigns.edit',compact('campaign','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditCampaignsRequest $request, $id)
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
            Campaign::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }

    public function approve( Request $request)
    {
        if ( $request->ajax() ) {

            $settings = Setting::first();
            $amount = $settings->campaign_period;

            $campaign = Campaign::find( $request->id );
            $end_date =  Carbon::parse($campaign->end_at)->addHours(3);
            $end_date = $end_date->addDays($amount);
            $campaign->status = '1';
            $campaign->end_at = $end_date;
            $campaign->save();



            $user_player_ids = $this->getUserSinglePlayerIds($campaign->user_id);
            sendNotification(0,'Your campaign has been approved','تم الموافقة على عرض الحملة ',$user_player_ids,"public",['campaign_id' =>  (int)$request->id,'type' =>  20,'type_title'  => 'new campaign']);

            
        $campaign_categories = CampaignCategory::where('campaign_id',$request->id)->pluck('category_id')->toArray();
        $campaign_countries = CampaignCountry::where('campaign_id',$request->id)->pluck('country_id')->toArray();
        
        
            $users = DB::table('users')
            ->join('user_categories', 'users.id', '=', 'user_categories.user_id')
            ->join('user_countries', 'users.id', '=', 'user_countries.user_id')
            ->join('user_player_ids', 'users.id', '=', 'user_player_ids.user_id');
            if($campaign_categories){
                $users->whereIn('user_categories.categories_id',$campaign_categories);
            }
            if($campaign_countries){
                $users->whereIn('user_countries.country_id',$campaign_countries);
            }
            $users->select('user_player_ids.*');
            $users->groupBy('users.id');
            $users->orderBy("updated_at",'DESC');

            $player_ids = $users->pluck('user_player_ids.player_id')->toArray();
            $result = sendNotification(1,'A new campaign was added','يوجد حملة جديدة',$player_ids,'public',
                                  ['campaign_id' =>  (int)$request->id,'type'=>  20,'type_title'=> 'new campaign']);
            return response(['msg' => 'approved', 'status' => 'success']);
        }

        
    }

    public function getUserPlayerIds()
    {
        $player_ids = UserPlayerId::select("user_player_ids.player_id")->join('users','users.id','user_player_ids.user_id')->where('users.account_type','1')->pluck('player_id')->toArray();
        return $player_ids ? $player_ids : null;
    }


    //  public function approved( Request $request)
    // {
    //     if ( $request->ajax() ) {
    //         $campaign = Campaign::find( $request->id );
    //         $campaign->status = '1';
    //         //$campaign->save();
    //         $player_ids = $this->getUserPlayerIds();
    //         dd($player_ids);
    //         sendNotification(1,'A new campaign was added','يوجد حملة جديدة',$player_ids,
    //                               ['campaign_id' =>  (int)$request->id,'type'=>  20,'type_title'=> 'new campaign']);
            
    //         return response(['msg' => 'activated', 'status' => 'success']);
    //     }

        
    // }

    public function reject( Request $request )
    {
        $campaign =  Campaign::find( $request->id );
        if ( $request->ajax() ) {
            $campaign->status = '0';
            $campaign->save();
            return response(['msg' => 'banned', 'status' => 'success']);
        }

    }


  
}
