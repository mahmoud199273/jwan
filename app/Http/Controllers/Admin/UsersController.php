<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\EditUserRequest;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\User;
use Illuminate\Http\Request;


class UsersController extends Controller
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
        $users = User::where('account_type','0')->latest()->paginate(10);
        return view('admin.users.index',compact('users'));
    }

       public function search( Request $request )
    {
        $query =  $request->q;
        
        if ( $query == "") {
            return redirect()->back();
        }else{
             $users   = User::where([['name', 'LIKE', '%' . $query. '%'],
                                            ['account_type','0']] )
                                     ->orWhere([['phone', 'LIKE', '%' . $query. '%'],
                                        ['account_type','0']] )
                                     ->paginate(10);
            $users->appends( ['q' => $request->q] );

            if (count ( $users ) > 0){
                return view('admin.users.index',[ 'users' => $users ])->withQuery($query);
            }else{
                return view('admin.users.index',[ 'users'=>null ,'message' => __('admin.no_result') ]);
            }
            //dd($users);
        }
    }

 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries =  Country::all();

        return view('admin.users.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
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
        //dd($id);
        $user = User::find($id);
        //dd($user);
        $countries =  Country::all();
        return view('admin.users.show',compact('user','countries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $countries =  Country::all();

        return view('admin.users.edit',compact('user','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, $id)
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
            User::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
    }


    public function activate( Request $request)
    {
        if ( $request->ajax() ) {
            $user = User::find( $request->id );
            $user->is_active = '1';
            $user->save();
            return response(['msg' => 'activated', 'status' => 'success']);
        }

        
    }

    public function ban( Request $request )
    {
        $user =  User::find( $request->id );
        if ( $request->ajax() ) {
            $user->is_active = '0';
            $user->save();
            return response(['msg' => 'banned', 'status' => 'success']);
        }

    }
}
