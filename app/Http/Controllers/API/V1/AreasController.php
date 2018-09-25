<?php

 
namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Transformers\AreasTransformer;
use App\Area;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class AreasController extends BaseController  
{

    protected $areastransformer;


    function __construct(Request $request, AreasTransformer $areasTransformer ){
        App::setlocale($request->lang);
        // $this->middleware('jwt.auth');
        $this->areasTransformer = $areasTransformer;
    }

public function index()
{
    # code...
    $areas = $this->areasTransformer->transformCollection(Area::all());
    return $this->sendResponse($areas,'ares read succesfully',200);
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
