<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['prefix'=>'/','middleware'=>'authsign'],function(){
	Route::get('/Signin','LoginController@index');
	Route::post('/Signin','LoginController@signin');
});


Route::group(['prefix'=>'/','middleware'=>'authpage'],function(){
	Route::get('/Order/Ready','HomeController@oready');
	Route::get('/Order/PO','HomeController@opo');
	Route::get('/Transaksi','HomeController@transaction');
	Route::get('/Signout','LoginController@signout');
	Route::post('/Product/Buy','HomeController@buy');
	
	
});

Route::get('/home', 'HomeController@index');
Route::get('/','HomeController@pready');
Route::get('/Product/Ready','HomeController@pready');
Route::get('/Product/PO','HomeController@ppo');
Route::get('/Pembayaran','HomeController@help');
Route::get('/Product/{id}/{clean}','HomeController@pdetail');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
