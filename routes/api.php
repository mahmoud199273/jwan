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



Route::post('user/send/reset/code'	, 'API\V1\ResetPasswordController@sendCode');

Route::post('user/send/email'	, 'API\V1\ResetPasswordController@sendMail');

Route::post('user/verify/reset/code', 'API\V1\ResetPasswordController@verifyCode');
Route::post('user/reset/password'	, 'API\V1\ResetPasswordController@resetPassword');

Route::post('influncer/send/reset/code', 'API\V1\ResetPasswordController@sendCode');
Route::post('influncer/verify/reset/code', 'API\V1\ResetPasswordController@verifyCode');
Route::post('influncer/reset/password', 'API\V1\ResetPasswordController@resetPassword');


Route::get('user/profile', 'API\V1\UserController@profile');

Route::post('user/update/profile', 'API\V1\UserController@updateProfile');

Route::post('user/update/channels', 'API\V1\UserController@userChannels');



Route::post('user/update/password'	, 'API\V1\UserController@updatePassword');

Route::post('user/update/password'	, 'API\V1\UserController@updatePassword');

Route::post('user/send/complanit', 'API\V1\ComplaintsController@store');

Route::post('user/update/player_id'	, 'API\V1\UserController@updatePlayerId');


Route::get('user/notifications','API\V1\UserController@getNotifications');


//Influncer Routes

Route::post('influncer/login', 'API\V1\AuthController@login');

Route::post('influncer/register', 'API\V1\AuthController@registerInfluncer');

Route::post('influncer/login', 'API\V1\AuthController@login');


Route::post('influncer/update/player_id','API\V1\UserController@updatePlayerId');

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


 // m.abdelrahman api links (user profile for influencer , influencer profile for user)
 Route::get('influencer/user/profile/{id}', 'API\V1\UserController@influncerUserProfile'); // influencer view user profile and campaignes
 Route::get('influencer/user/campaigns/{id}','API\V1\CampignsController@allCampaigns');
 Route::get('user/influencer/profile/{id}', 'API\V1\UserController@UserinfluncerProfile'); // user view influencer profile and campaignes

 // start Camapign routes

 Route::post('/user/add/campaign','API\V1\CampignsController@store');

 Route::get('/user/archive/campaign','API\V1\CampignsController@archiveCampaigns');

 Route::get('/user/campaigns','API\V1\CampignsController@allCampaigns');

 Route::get('/influncer/campaigns','API\V1\CampignsController@index');


 Route::get('/campaign/{id}','API\V1\CampignsController@show');

 Route::post('/approve/campaign','API\V1\CampignsController@approveCampaign');

 Route::post('/extend/campaign','API\V1\CampignsController@extendCampaign');

 Route::post('/cancel/campaign','API\V1\CampignsController@cancelCampaign');
 Route::post('/close/campaign','API\V1\CampignsController@closeCampaign');

 Route::post('/camapign/delete','API\V1\CampignsController@destroy');

  Route::post('/chat/add', 'API\V1\ChatController@store');

  Route::post('/chat/index', 'API\V1\ChatController@index');



  Route::get('bank/app_accounts','API\V1\AppBankController@index');

  Route::get('banks/list','API\V1\BanksController@index');

 //	Route::post('/camapign/update'	, 'API\V1\CampignsController@update');

 /* influncer camapign routes */

 Route::post('/influncer/campaign/status','API\V1\CampignsController@status');

 Route::get('skipped/campaign','API\V1\CampignsController@skipped');

 Route::get('favorite/campaign','API\V1\CampignsController@favorite');

 /* influncer offers route */

  Route::post('/influncer/create/offer','API\V1\OffersController@store');
  Route::post('/influncer/update/offer','API\V1\OffersController@update');

 //Route::post('/user/accept/offer','API\V1\OffersController@acceptOffer');

Route::post('/offer/user/status','API\V1\OffersController@offerStatus');

Route::get('/user/campaign/offers/{campaign_id}','API\V1\OffersController@index');


Route::get('/influncer/offers','API\V1\OffersController@allOffers');

Route::get('/influncer/offer/{id}','API\V1\OffersController@show');


Route::get('/user/offer/{id}','API\V1\OffersController@show');

Route::get('/user/campaign/offer/approve/{id}','API\V1\OffersController@approve');
Route::get('/user/campaign/offer/pay/{id}','API\V1\OffersController@pay');
Route::get('/user/campaign/offer/reject/{id}','API\V1\OffersController@reject');
//Route::post('/user/campaign/offer/finish/{id}','API\V1\OffersController@finish');
Route::post('/user/campaign/offer/finish','API\V1\OffersController@finish');
Route::get('/user/campaign/offer/cancel/{id}','API\V1\OffersController@user_cancel');
//Route::post('/user/campaign/offer/rate/{id}','API\V1\OffersController@user_rate');
Route::post('/user/campaign/offer/rate','API\V1\OffersController@user_rate');



Route::get('/influncer/campaign/offer/inprogress/{id}','API\V1\OffersController@inprogress');
Route::get('/influncer/campaign/offer/proof/{id}','API\V1\OffersController@proof');
Route::get('/influncer/campaign/offer/cancel/{id}','API\V1\OffersController@influncer_cancel');
//Route::post('/influncer/campaign/offer/rate/{id}','API\V1\OffersController@influncer_rate');
Route::post('/influncer/campaign/offer/rate','API\V1\OffersController@influncer_rate');

Route::get('/influncer/campaign/offers/new','API\V1\OffersController@influncer_offer_new');

Route::get('/influncer/campaign/offers/inprogress','API\V1\OffersController@influncer_offer_inprogress');

Route::get('/influncer/campaign/offers/finished','API\V1\OffersController@influncer_offer_finished');



Route::get('/user/notifications'		, 'API\V1\UserController@getNotifications');
Route::get('/influncer/notifications'		, 'API\V1\UserController@getNotifications');


//Route::get('/influncer/offers/get_inprogress','API\V1\OffersController@get_inprogresses');

//Route::get('/influncer/offers/get_proofed','API\V1\OffersController@get_proofed');

//Route::get('/influncer/offers/cancel','API\V1\OffersController@canceledOffers');



  Route::get('influncer/banks/list','API\V1\UserBanksController@index');
  Route::post('influncer/banks/store', 'API\V1\UserBanksController@store');

  Route::post('user/transaction/store', 'API\V1\TransactionsController@store');
  Route::get('user/transaction/list', 'API\V1\TransactionsController@index');
  Route::get('influncer/transaction/list', 'API\V1\TransactionsController@index');
  Route::get('user/transaction/details/{id}', 'API\V1\TransactionsController@details');
  Route::get('influncer/transaction/details/{id}', 'API\V1\TransactionsController@details');


/* about the app - license agreement */
Route::get('/about/app','API\V1\AboutAppController@index') ;

Route::get('user/privacy/policy','API\V1\AboutAppController@privacyPolicy');

Route::get('influncer/privacy/policy','API\V1\AboutAppController@influncerPrivacyPolicy');

Route::post('contact','API\V1\AboutAppController@contactUs');


});
