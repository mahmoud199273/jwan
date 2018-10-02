<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as Controller;
use App\Transformers\ComplaintsTransformer;
use App\User;
use App\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ComplaintsController extends Controller
{

    protected $compliantsTransformer;

    function __construct(Request $request, ComplaintsTransformer $compliantsTransformer){
        App::setlocale($request->lang);
    	$this->middleware('jwt.auth')->only(['store']);
        $this->compliantsTransformer   = $compliantsTransformer;
    }


   /* public function allCategories( Request $request )
    {
        return $this->respond( ['data' => $this->categoryTransformer->transformCollection(Category::where('is_active','1')->get())]);   
    }


    public function coursesByCategoryId(Request $request , $id)
    {
        $validator = Validator::make( ['id' =>  $request->id ], [
            'id'    => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        if ($request->limit) {
            $this->setPagination($request->limit);
        }

        $pagination = Course::where('category_id' , $request->id)->paginate($this->getPagination());

        $courses = $this->courseTransformer->transformCollection(collect($pagination->items()));

        return $this->respondWithPagination($pagination ,['data' =>  $courses]);    
    }


    public function getAllCourses( Request $request )
    {
    	if ( $request->limit ) {
    		$this->setPagination($request->limit);
    	}

    	$orderBy = 'created_at';

    	if ($request->sort == 'latest') {
    		$orderBy = 'created_at';
    	}elseif ($request->sort == 'rate') {
    		$orderBy = 'rate';
    	}

    	if ($request->q) {
    		$q = $request->q;

	    	$pagination = Course::join('course_rates','course_rates.course_id','=','courses.id')
	    								   ->join('users','courses.instructor_id','=','users.id')
	    	                               ->select('courses.*','users.name',DB::raw('SUM(course_rates.rate) as rate'))
	                                        ->where([
	                                            ['courses.is_active', '1'] ,
	                                            ['courses.name', 'LIKE', '%'.$q .'%']
	                                        ])
	                                        ->orWhere([ 
	                                        	['courses.is_active', '1'] ,
	                                            ['users.name', 'LIKE', '%'.$q .'%']
	                                        ])
	    	                               ->groupBy('courses.id')
	    	                               ->orderBy($orderBy,'DESC')
	    	                               ->paginate($this->getPagination());
    	}else{
    		$pagination = Course::join('course_rates','course_rates.course_id','=','courses.id')
	    								   ->join('users','courses.instructor_id','=','users.id')
	    	                               ->select('courses.*','users.name',DB::raw('SUM(course_rates.rate) as rate'))
	    	                               ->groupBy('courses.id')
	    	                               ->orderBy($orderBy,'DESC')
	    	                               ->paginate($this->getPagination());

    	}

    	$courses =  $this->courseTransformer->transformCollection(collect($pagination->items()));
 	
    	return $this->respondWithPagination( $pagination, [ 'data' =>  $courses ]);
    }



    public function show( Request $request , $id )
    {

        $validator = Validator::make( ['id' =>  $request->id ], [
            'id'    => 'required|exists:courses,id',
        ]);
        return $validator->fails() ? $this->setStatusCode(422)->respondWithError('parameters faild validation') :
                                        $this->respond(['data' =>  $this->courseTransformer->transform(Course::find($request->id))]);

    }*/




    public function store( Request $request )
    {
        $user =  $this->getAuthenticatedUser();

        $validator = Validator::make( $request->all(), [

            'title' => 'required',

            'body'  => 'required'

        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        $complaint = new Complaint;


        $complaint->title            = $request->title;

        $complaint->body            = $request->body;

        $complaint->user_id          = $user->id;

        $complaint->save();

        return $this->respondWithSuccess(trans('api_msgs.created'));

    }


    /*public function update( Request $request )
    {
        $instructor =  $this->getAuthenticatedUser();

        $validator = Validator::make( $request->all(), [
            'id'                    => 'required|exists:courses,id',
            'category_id'           => 'required|exists:categories,id',
            'name'                  => 'required|string|max:50|min:2',
            'price'                 => 'required',
            'description'           => 'required',
            'is_certificated'       => ['required', Rule::in([0,1])],
            'number_of_students'    => 'required',
            'number_of_sessions'    => 'required',
            'number_of_hours'       => 'required'
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError($validator->messages());
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        $course = Course::find( $request->id );
        $course->instructor_id          = $instructor->id;
        $course->category_id            = $request->category_id;
        $course->name                   = $request->name;
        $course->price                  = $request->price*100;
        $course->discount               = $request->discount*100;
        $course->description            = $request->description;
        $course->certificate            = $request->is_certificated;
        $course->number_of_students     = $request->number_of_students;
        $course->number_of_hours        = $request->number_of_hours;
        $course->number_of_sessions     = $request->number_of_sessions;

        if ($request->image) {
            $course->image                  = $request->image ;
        }
        $course->save();


        return $this->respondWithSuccess(trans('api_msgs.updated'));

    }





    public function destroy(Request $request )
    {
        $instructor =  $this->getAuthenticatedUser();

        $validator = Validator::make( ['id' =>  $request->id ], [
            'id'    => 'required|exists:courses,id',
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        Course::where([['id', $request->id],['instructor_id', $instructor->id]])->delete();

        return $this->respondWithSuccess(trans('api_msgs.deleted'));

    }


    public function rateCourse( Request $request )
    {

        $user =  $this->getAuthenticatedUser();

        $validator = Validator::make( $request->all(), [
            'id'    => 'required|exists:courses,id',
            'rate'  => 'required|max:5|min:1'
        ]);

        if ($validator->fails()) {
            return $this->setStatusCode(422)->respondWithError('parameters faild validation');
        }

        $rate = CourseRate::firstOrNew(['user_id' => $user->id ,'course_id' => $request->id ]);
        $rate->rate     =  $request->rate;
        $rate->comment  =  $request->comment;
        $rate->save();

        $course =  Course::find($request->id);
        $player_ids = $this->getUserPlayerIds($course->instructor_id);
        Notification::create(['user_id' => $course->instructor_id ,'message' => 'يوجد تعليق جديد علي كورس '.$course->name ]);
        sendNotification('يوجد تعليق جديد علي كورس '.$course->name , $player_ids ,['data' => ['course_id' =>  $course->id]]);
        return $this->respondWithSuccess('success');
        
    }*/

 




}
