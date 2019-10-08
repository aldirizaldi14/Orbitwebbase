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
Auth::routes(['register' => false]);
Route::get('/', 'HomeController@index');
Route::get('/logout', 'Auth\LoginController@logout');

Route::group(['middleware' => ['auth', 'auth:web']], function () {
	Route::get('/home', 'HomeController@index')->name('home');

	Route::get('/warehouse', 'WarehouseController@index');
	Route::get('/warehouse/data', 'WarehouseController@data');
	Route::post('/warehouse', 'WarehouseController@create');
	Route::post('/warehouse/export', 'WarehouseController@export');
	Route::post('/warehouse/{id}', 'WarehouseController@update');
	Route::delete('/warehouse/{id}', 'WarehouseController@delete');

	Route::get('/area', 'AreaController@index');
	Route::get('/area/data', 'AreaController@data');
	Route::post('/area', 'AreaController@create');
	Route::post('/area/export', 'AreaController@export');
	Route::post('/area/{id}', 'AreaController@update');
	Route::delete('/area/{id}', 'AreaController@delete');

	Route::get('/line', 'LineController@index');
	Route::get('/line/data', 'LineController@data');
	Route::post('/line', 'LineController@create');
	Route::post('/line/export', 'LineController@export');
	Route::post('/line/{id}', 'LineController@update');
	Route::delete('/line/{id}', 'LineController@delete');

	Route::get('/product', 'ProductController@index');
	Route::get('/product/data', 'ProductController@data');
	Route::post('/product', 'ProductController@create');
	Route::post('/product/export', 'ProductController@export');
	Route::post('/product/{id}', 'ProductController@update');
	Route::delete('/product/{id}', 'ProductController@delete');

	Route::get('/production', 'ProductionController@index');
	Route::get('/production/data', 'ProductionController@data');
	Route::post('/production', 'ProductionController@create');
	Route::post('/production/export', 'ProductionController@export');
	Route::post('/production/{id}', 'ProductionController@update');
	Route::delete('/production/{id}', 'ProductionController@delete');

	Route::get('/transfer', 'TransferController@index');
	Route::get('/transfer/data', 'TransferController@data');
	Route::post('/transfer', 'TransferController@create');
	Route::post('/transfer/export', 'TransferController@export');
	Route::post('/transfer/{id}', 'TransferController@update');
	Route::delete('/transfer/{id}', 'TransferController@delete');

	Route::get('/receipt', 'ReceiptController@index');
	Route::get('/receipt/data', 'ReceiptController@data');
	Route::post('/receipt', 'ReceiptController@create');
	Route::post('/receipt/export', 'ReceiptController@export');
	Route::post('/receipt/{id}', 'ReceiptController@update');
	Route::delete('/receipt/{id}', 'ReceiptController@delete');
});