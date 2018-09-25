<?php

 
namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Transformers\CategoriesTransformer;
use App\Category;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class CategoriesController extends BaseController  
{

    protected $categoriestransformer;

    function __construct(Request $request, CategoriesTransformer $categoriesTransformer ){
        App::setlocale($request->lang);
        // $this->middleware('jwt.auth');
        $this->categoriesTransformer = $categoriesTransformer;
    }

public function index()
{
    # code...
    $categories = $this->categoriesTransformer->transformCollection( Category::all());
    return $this->sendResponse($categories, 'categories read succesfully',200);
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
