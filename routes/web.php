<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


if (!defined('ADMIN_PATH')) {
	define('ADMIN_PATH', 'admin');
}


Route::group(['prefix'=>ADMIN_PATH],function(){

	Route::group(['namespace'=>'Admin'],function(){

		Route::get('/admin', 'DashboardController@index');

		Route::resource('country','CountriesController');
		Route::resource('area','AreasController');
		Route::resource('category','CategoryController');


		Route::group(['prefix' => '/auth'], function() {
            Route::post('/login', 'AuthController@login');
        });

		Route::get('/'		                , 'AuthController@loginIndex');
        Route::get('/login'                 , 'AuthController@loginIndex');
        Route::get('/logout'          , 'AuthController@logout');
        Route::get('/profile'         , 'AuthController@profile');
		Route::post('/profile/edit'	, 'AuthController@updateProfile');

		Route::get('/dashboard' , 'DashboardController@index');


		Route::resource('country','CountriesController');
		Route::resource('area','AreasController');
		Route::resource('category','CategoriesController');
		Route::resource('natoinality','NatoinalitiesController');
		Route::resource('users','UsersController');
		Route::post('/users/activate'       , 'UsersControllers@activate');
		Route::post('/users/ban'            , 'UsersControllers@ban');
		Route::get('/users/search'            , 'UsersControllers@search');

		Route::resource('influencers','InfluencersController');
		Route::get('/influencers/search'            , 'InfluencersController@search');

		Route::resource('complaints','ComplaintsController');
		Route::resource('campaigns','CampaignsController');
		Route::resource('pages','PagesController');
		Route::resource('bank','BankAccountsController');
		Route::resource('offers','OffersController');
		Route::get('offers/{id}/{campaign}','OffersController@campaigns');
	});
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
