<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Http\Requests\Admin\User\EditUserRequest;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\User;
use Illuminate\Http\Request;
=======
use App\Models\Admin\User;
use App\Models\Admin\Country;
use App\Models\Admin\Area;
use App\Models\Admin\Category;
use App\Models\Admin\nationalities;
>>>>>>> 57a21f079cc8787a516b8b971b392ed25d58305d


class UserController extends Controller
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
        $users = User::where('type','user')->latest()->paginate(10);
        return view('admin.users.index',compact('users'));
    }

       public function search( Request $request )
    {
        $query =  $request->q;
        
        if ( $query == "") {
            return redirect()->back();
        }else{
             $users   = User::where([['name', 'LIKE', '%' . $query. '%'],['type','user']] )
                                     ->orWhere([['phone', 'LIKE', '%' . $query. '%'],['type','user']] )
                                     ->paginate(10);
            $users->appends( ['q' => $request->q] );
            if (count ( $users ) > 0){
                return view('admin.users.index',[ 'users' => $users ])->withQuery($query);
            }else{
                return view('admin.users.index',[ 'users'=>null ,'message' => __('admin.no_result') ]);
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
        $cities =  City::all();

        return view('admin.users.create',compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
<<<<<<< HEAD
        $request->persist();
        return redirect()->back()->with('status' , __('admin.created') );

=======
        $countries = Country::pluck('name_ar', 'id');
        $categories = Category::pluck('name_ar', 'id');
        $areas    = Area::pluck('name_ar', 'id');
        $nationality    = nationalities::pluck('name_ar', 'id');
        $activation = ['1' => __('lang.active'), '0' => __('lang.in-active')];
        $gender = ['1' => __('lang.male'), '0' => __('lang.female')];
        $account_manger = ['1' => __('lang.Business manager'), '0' => __('lang.Personal')];
        $type = ['2' => __('lang.Government'),'1' => __('lang.Private sector'), '0' => __('lang.Personal')];
        
        view()->share(compact('countries','categories', 'areas','nationality','activation','gender','account_manger','type'));
>>>>>>> 57a21f079cc8787a516b8b971b392ed25d58305d
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
<<<<<<< HEAD
        $user = User::find($id);
        $cities =  City::all();
        return view('admin.users.show',compact('user','cities'));
=======
        $countries = Country::pluck('name_ar', 'id');
        $categories = Category::pluck('name_ar', 'id');
        $areas    = Area::pluck('name_ar', 'id');
        $nationality    = nationalities::pluck('name_ar', 'id');
        $activation = ['1' => __('lang.active'), '0' => __('lang.in-active')];
        $gender = ['1' => __('lang.male'), '0' => __('lang.female')];
        $account_manger = ['1' => __('lang.Business manager'), '0' => __('lang.Personal')];
        $type = ['2' => __('lang.Government'),'1' => __('lang.Private sector'), '0' => __('lang.Personal')];
        
        view()->share(compact('countries','categories', 'areas','nationality','activation','gender','account_manger','type'));
>>>>>>> 57a21f079cc8787a516b8b971b392ed25d58305d
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
        $cities =  City::all();

        return view('admin.users.edit',compact('user','cities'));
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
<<<<<<< HEAD
        $request->persist($id);
        return redirect()->back()->with('status' , __('admin.updated') );
=======
        return $this->v([
            'name'       => 'required|string|max:50|min:2',
            'email'      => 'required|email|max:255|unique:users',
            'phone'      => 'required|unique:users',
            'notes'      => 'required',
            'password'   => 'required|string|max:25|min:8',
            'image'      => 'image',
        ]);
>>>>>>> 57a21f079cc8787a516b8b971b392ed25d58305d
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
<<<<<<< HEAD
        if ($request->ajax()) {
            User::find($id)->delete();
            return response(['msg' => 'deleted', 'status' => 'success']);
        }
=======
       return $this->v([
            'name'       => 'required|max:255',
            'email'      => 'required|email|max:255|unique:users,email,'.request()->route('user'),
            'phone'      => 'required|unique:users,phone,'.request()->route('user'),
            'notes'      => 'required',
            'password'   => 'required|string|max:25|min:8',
            'image'      => 'image',
        ]);
>>>>>>> 57a21f079cc8787a516b8b971b392ed25d58305d
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
