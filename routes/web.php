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

Route::get('/test',"TestController@index");

Route::group(['prefix'=>ADMIN_PATH],function(){

	// Route::group(['namespace'=>'Auth\Admin'], function(){
	// 	Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
	// 	Route::post('login', 'LoginController@login');
	// 	Route::post('logout', 'LoginController@logout')->name('admin.logout');
	// 	// Password Reset Routes...
	// 	Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');

	// 	Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
	// 	Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('admin.password.reset');
	// 	Route::post('password/reset', 'ResetPasswordController@reset');
	// });


//	Route::group(['middleware'=>['admin.auth'],'namespace'=>'Admin'],function(){
	Route::group(['namespace'=>'Admin'],function(){


		
		Route::get('/admin', 'DashboardController@index');
		

		Route::resource('users','UsersController');
		

		Route::post('/users/activate'       , 'UsersController@activate');
		Route::post('/users/ban'            , 'UsersController@ban');
		Route::get('/user/search'           , 'UsersController@search');

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
		Route::get('/countries/search','CountriesController@search');
		

		Route::resource('area','AreasController');
		Route::get('/areas/search','AreasController@search');

		Route::resource('category','CategoriesController');
		Route::get('/categories/search','CategoriesController@search');

		Route::resource('natoinality','NatoinalitiesController');
		Route::get('Natoinalities/search','NatoinalitiesController@search');
		//Route::resource('users','UserController');
		//Route::post('/users/activate'       , 'UserController@activate');
		//Route::post('/users/ban'            , 'UserController@ban');
		//Route::get('/user/search'           , 'UserController@search');

		Route::resource('influencers','InfluencersController');
		Route::get('influencer/search','InfluencersController@search');

		Route::resource('complaints','ComplaintsController');
		Route::get('complaint/search','ComplaintsController@search');

		Route::resource('campaigns','CampaignsController');
		Route::get('/campaign/search','CampaignsController@search');

		Route::resource('pages','PagesController');
		Route::resource('bank','BankAccountsController');
		//Route::get('offers/{id}', 'OffersController@campaigns');

		Route::resource('offers','OffersController');
		Route::get('offer/search','OffersController@search');
		
		// Route::get('offers', 'OffersController@index');
		// Route::get('offers/show/{id}', 'OffersController@show');

	});
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
