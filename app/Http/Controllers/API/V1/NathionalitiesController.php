<?php


namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Transformers\nationalitiesTransformer;
use App\nationality;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class nationalitiesController extends BaseController  
{

        protected $nationalitiesTransformer;

        function __construct(Request $request, nationalitiesTransformer $nationalitiesTransformer ){
        App::setlocale($request->lang);
        // $this->middleware('jwt.auth');
        $this->nationalitiesTransformer = $nationalitiesTransformer;
    }


public function index()
{
    # code...
    $nationalities = $this->nationalitiesTransformer->transformCollection(nationality::all());

    return $this->sendResponse($nationalities, 'nationalities read succesfully',200);
}


/*public function store(Request $request)
{
    # code...
    
    
}






public function show( $id)
{
    $country = Country::find($id);
    if (   is_null($country)   ) {
        # code...
        return $this->sendError(  'post not found ! ');
    }
    return $this->sendResponse($country->toArray(), 'country read succesfully');
    
}



// update book 
public function update(Request $request , Country $country)
{
    
    
}





// delete book 
public function destroy(Country $country)
{
 
    
    
}*/



    
}
