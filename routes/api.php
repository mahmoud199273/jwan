<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('user/register', 'APIRegisterController@register');

//Route::post('user/login', 'APILoginController@login');



Route::middleware('jwt.auth')->get('/users', function (Request $request) {
    return auth()->user();
});

//Route::get('user/{id}/', 'APIRegisterController@showprofile');

//Route::post('user/{id}/','APIRegisterController@updateProfile');

Route::group(['prefix' => 'v1/{lang}'], function() {


Route::get('testNot', function(){
  dd("he");
  die("hello");
});



// App Meta Data
Route::get('app/data', 'API\V1\AppController@index');

Route::get('products', 'API\V1\ProductsController@index');
Route::get('tips', 'API\V1\ProductsController@Tips');
Route::get('coupons', 'API\V1\ProductsController@Coupons');
Route::get('offers', 'API\V1\ProductsController@Offers');
Route::get('notifications', 'API\V1\ProductsController@Notifications');
Route::get('about', 'API\V1\AboutAppController@index');
Route::get('faqs', 'API\V1\ProductsController@Faqs');
Route::get('opinion', 'API\V1\ProductsController@Opinion');
Route::post('opinion/answer', 'API\V1\ProductsController@OpinionAnswer');
Route::post('order/save', 'API\V1\ProductsController@SaveOrder');
Route::get('order/current', 'API\V1\ProductsController@CurrentOrders');
Route::get('order/past', 'API\V1\ProductsController@PastOrders');
  // Users Routes


});
