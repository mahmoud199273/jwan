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
use App\Models\AppSettings;


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

public function settings(){
    $settings = AppSettings::all();
    $response_array = [];
    foreach($settings as $set){
        $response_array[$set->field] = $set->value;
    }
    return $response_array; 
}




}
