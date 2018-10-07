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

<<<<<<< HEAD
		//Route::get('/test',"TestController@index");

		Route::get('/admin',function(){
			return " admin` ";
		});
		//Route::get('/admin', 'DashboardController@index');
		Route::get('profile','ProfileController@getIndex');
		Route::post('profile','ProfileController@postIndex');

		Route::resource('country','CountriesController');
		//Route::post('country/activate/{id}', 'CountryController@activate');
		Route::resource('area','AreaController');
		Route::resource('category','CategoryController');
		Route::resource('natoinality','NatoinalityController');
		Route::resource('users','UserController');
		//Route::get('/users','UsersController@index');
		Route::post('/users/activate'       , 'UserController@activate');
		Route::post('/users/ban'            , 'UserController@ban');
=======
		Route::group(['prefix' => '/auth'], function() {
            Route::post('/login', 'AuthController@login');
        });

		Route::get('/'		                , 'AuthController@loginIndex');
        Route::get('/login'                 , 'AuthController@loginIndex');
        Route::get('/logout'          , 'AuthController@logout');
        Route::get('/profile'         , 'AuthController@profile');
		Route::post('/profile/edit'	, 'AuthController@updateProfile');

		Route::get('/dashboard' , 'DashboardController@index');
		
		
		Route::get('/admin', 'DashboardController@index');
		//Route::get('profile','ProfileController@getIndex');
		//Route::post('profile','ProfileController@postIndex');

		Route::resource('country','CountriesController');
		//Route::post('country/activate/{id}', 'CountryController@activate');
		Route::resource('area','AreasController');
		Route::resource('category','CategoriesController');
		Route::resource('natoinality','NatoinalitiesController');
		Route::resource('users','UsersController');
		Route::post('/users/activate'       , 'UsersControllers@activate');
		Route::post('/users/ban'            , 'UsersControllers@ban');
>>>>>>> 05e032cc8f73596f709af7065e1e5b03daf17e34
		
		Route::resource('influencers','InfluencersController');

		Route::resource('complaints','ComplaintsController');
		Route::resource('campaigns','CampaignsController');
		
	});
});
