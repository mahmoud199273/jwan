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
		Route::get('profile','ProfileController@getIndex');
		Route::post('profile','ProfileController@postIndex');

		Route::resource('country','CountryController');
		//Route::post('country/activate/{id}', 'CountryController@activate');
		Route::resource('area','AreaController');
		Route::resource('category','CategoryController');
		Route::resource('natoinality','NatoinalityController');
		Route::resource('user','UserController');
	});
});
