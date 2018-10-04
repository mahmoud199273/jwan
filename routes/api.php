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

// App Meta Data

Route::get('app/data', 'API\V1\AppController@index');

  // Users Routes

Route::post('/validate/email', 'API\V1\AuthController@isEmailExists');

Route::post('/validate/phone', 'API\V1\AuthController@checkPhone');

Route::post('/check','API\V1\AuthController@checkData');

Route::post('file/upload','API\V1\FileController@fileUpload');

Route::post('user/register', 'API\V1\AuthController@register');

Route::post('user/login', 'API\V1\AuthController@login');

Route::post('/logout', 'API\V1\AuthController@logout');

Route::post('/refresh/token','API\V1\AuthController@refreshToken');



//Route::post('/reset/password', 'API\V1\ResetPasswordController@resetPassword');



Route::get('user/profile', 'API\V1\UserController@profile');

Route::post('user/update/profile', 'API\V1\UserController@updateProfile');



Route::post('user/update/password'	, 'API\V1\UserController@updatePassword');

Route::post('user/send/complanit', 'API\V1\ComplaintsController@store');


//Influncer Routes

Route::post('influncer/login', 'API\V1\AuthController@login');

Route::post('influncer/register', 'API\V1\AuthController@registerInfluncer');

Route::post('influncer/login', 'API\V1\AuthController@login');

//Route::post('influncer/logout', 'API\V1\AuthController@logout');


Route::get('influncer/profile', 'API\V1\UserController@influncerProfile');

Route::post('influncer/update/profile', 'API\V1\UserController@updateInfluncerProfile');



Route::post('influncer/update/password'	, 'API\V1\UserController@updateInfluncerPassword');

Route::post('influncer/update/followers','API\V1\UserController@updateFollowers');

Route::post('influncer/send/complanit', 'API\V1\ComplaintsController@store');


Route::post('influncer/update/profile', 'API\V1\UserController@updateInfluncerProfile');


 Route::resource('countries', 'API\V1\CountryController');

 Route::resource('areas', 'API\V1\AreasController');

 Route::resource('categories', 'API\V1\CategoriesController');

 Route::get('/nathionalities','API\V1\NathionalitiesController@index');

 // start Camapign routes 

 Route::post('/user/add/camapign','API\V1\CampignsContrller@store');

 Route::get('/user/camapigns','API\V1\CampignsContrller@index');

 Route::get('/camapign/{id}','API\V1\CampignsContrller@show');

 //Route::post('/camapign/update'	, 'API\V1\CampignsContrller@update');




});
