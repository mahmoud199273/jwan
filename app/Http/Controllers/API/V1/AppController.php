<?php


namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Transformers\CategoriesTransformer;
use App\Transformers\CountryTransformer;
use App\Transformers\NationalitiesTransformer;
use App\Category;
use App\Country;
use App\Area;
use App\Nationality;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class AppController extends BaseController
{

    protected $categoriestransformer, $countryTransformer, $nationalityTransformer;

    function __construct(Request $request, CategoriesTransformer $categoriesTransformer, CountryTransformer $countryTransformer,
  NationalitiesTransformer $nationalityTransformer ){
        App::setlocale($request->lang);
        $this->categoriesTransformer = $categoriesTransformer;
        $this->countryTransformer = $countryTransformer;
        $this->nationalityTransformer = $nationalityTransformer;
    }

public function index()
{
    # code...
    $categories = $this->categoriesTransformer->transformCollection( Category::all());
    $countries = $this->countryTransformer->transformCollection(Country::all());
    $nationalities = $this->nationalityTransformer->transformCollection(Nationality::all());
    return $this->sendResponse(array('categories'=>$categories, 'countries'=>$countries, 'nationalities'=>$nationalities), 'categories read succesfully',200);
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
