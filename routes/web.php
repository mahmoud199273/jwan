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
		

		/*Route::resource('users','UsersController');
		

		Route::post('/users/activate'       , 'UsersController@activate');
		Route::post('/users/ban'            , 'UsersController@ban');
		Route::get('/user/search'           , 'UsersController@search');

		Route::get('/admin', 'DashboardController@index');

		Route::resource('country','CountriesController');
		Route::resource('area','AreasController');
		Route::resource('category','CategoryController');*/



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
		


		//Route::resource('country','CountriesController');

		Route::resource('area','AreasController');
		Route::get('/areas/search','AreasController@search');

		Route::resource('category','CategoriesController');
		Route::get('/categories/search','CategoriesController@search');

		Route::resource('natoinality','NatoinalitiesController');

		Route::get('Natoinalities/search','NatoinalitiesController@search');
		Route::resource('users','UsersController');
		Route::post('/users/activate'       , 'UsersController@activate');
		Route::post('/users/ban'            , 'UsersController@ban');
		Route::get('/user/search'           , 'UsersController@search');

		Route::resource('influencers','InfluencersController');
		Route::post('/influencers/activate'       , 'InfluencersController@activate');
		Route::post('/influencers/ban'            , 'InfluencersController@ban');
		Route::get('influencer/search','InfluencersController@search');

		// Route::resource('users','UsersController');
		// Route::post('/users/activate'       , 'UsersControllers@activate');
		// Route::post('/users/ban'            , 'UsersControllers@ban');
		// Route::get('/user/search'            , 'UsersControllers@search');

		//Route::resource('influencers','InfluencersController');
		//Route::get('/influencers/search'            , 'InfluencersController@search');


		Route::resource('complaints','ComplaintsController');
		Route::get('complaint/search','ComplaintsController@search');

		Route::resource('campaigns','CampaignsController');
		Route::post('/campaigns/approved'       , 'CampaignsController@approved');
		Route::post('/campaigns/approve'       , 'CampaignsController@approve');
		Route::post('/campaigns/reject'        , 'CampaignsController@reject');
		Route::get('/campaign/search','CampaignsController@search');

		Route::resource('pages','PagesController');
		Route::get('page/search','PagesController@search');

		Route::resource('bank','BankController');
		Route::get('banks/search','BankController@search');

		

		Route::resource('bankaccounts','BankAccountsController');
		Route::get('bankaccount/search','BankAccountsController@search');

		Route::resource('transactions','TransactionsController');
		Route::get('transaction/users',['uses' => 'TransactionsController@index', 'account_type' => '0']);
		Route::get('transaction/influencers',['uses' => 'TransactionsController@index', 'account_type' => '1']);
		Route::post('/transaction/approve','TransactionsController@approve');
		Route::get('transaction/search','TransactionsController@search');
		Route::get('transactions/{id}/{user}','TransactionsController@userTransactions');

		Route::resource('appbankaccount','AppBankAccountsController');
		Route::get('appbankaccounts/search','AppBankAccountsController@search');
		

		Route::resource('aboutApp','AboutappController');

		//Route::get('offers/{id}', 'OffersController@campaigns');

		Route::resource('offers','OffersController');
		Route::get('offer/search','OffersController@search');
		
		// Route::get('offers', 'OffersController@index');
		// Route::get('offers/show/{id}', 'OffersController@show');


		Route::resource('offers','OffersController');
		Route::get('offers/{id}/{campaign}','OffersController@campaigns');

	});
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
