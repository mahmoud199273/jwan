<?php


namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Transformers\NathionalitiesTransformer;
use App\Nathionality;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class NathionalitiesController extends BaseController  
{

        protected $nathionalitiesTransformer;

        function __construct(Request $request, NathionalitiesTransformer $nathionalitiesTransformer ){
        App::setlocale($request->lang);
        // $this->middleware('jwt.auth');
        $this->nathionalitiesTransformer = $nathionalitiesTransformer;
    }


public function index()
{
    # code...
    $nathionalities = $this->nathionalitiesTransformer->transformCollection(Nathionality::all());

    return $this->sendResponse($nathionalities, 'nathionalities read succesfully',200);
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
