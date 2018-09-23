<?php


namespace App\Http\Controllers\API\V1;
use Illuminate\Http\Request;
use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Area;
use  Validator;


class AreasController extends BaseController  
{

public function index()
{
    # code...
    $ares = Area::all();
    return $this->sendResponse($ares->toArray(), 'ares read succesfully',200);
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
