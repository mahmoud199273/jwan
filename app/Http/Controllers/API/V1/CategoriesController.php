<?php


namespace App\Http\Controllers\API\V1;
use Illuminate\Http\Request;
use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Category;
use  Validator;


class CategoriesController extends BaseController  
{

public function index()
{
    # code...
    $categories = Category::all();
    return $this->sendResponse($categories->toArray(), 'categories read succesfully');
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
