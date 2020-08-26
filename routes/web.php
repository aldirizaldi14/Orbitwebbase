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

	Route::get('/user', 'UserController@index');
	Route::get('/user/data', 'UserController@data');
	Route::post('/user', 'UserController@create');
	Route::post('/user/export', 'UserController@export');
	Route::post('/user/{id}', 'UserController@update');
	Route::post('/user/delete/{id}', 'UserController@delete');

	Route::get('/warehouse', 'WarehouseController@index');
	Route::get('/warehouse/data', 'WarehouseController@data');
	Route::post('/warehouse', 'WarehouseController@create');
	Route::post('/warehouse/export', 'WarehouseController@export');
	Route::post('/warehouse/{id}', 'WarehouseController@update');
	Route::post('/warehouse/delete/{id}', 'WarehouseController@delete');

	Route::get('/area', 'AreaController@index');
	Route::get('/area/data', 'AreaController@data');
	Route::post('/area', 'AreaController@create');
	Route::post('/area/export', 'AreaController@export');
	Route::post('/area/{id}', 'AreaController@update');
	Route::post('/area/delete/{id}', 'AreaController@delete');

	Route::get('/line', 'LineController@index');
	Route::get('/line/data', 'LineController@data');
	Route::post('/line', 'LineController@create');
	Route::post('/line/export', 'LineController@export');
	Route::post('/line/{id}', 'LineController@update');
	Route::post('/line/delete/{id}', 'LineController@delete');

	Route::get('/product', 'ProductController@index');
	Route::get('/product/data', 'ProductController@data');
	Route::post('/product', 'ProductController@create');
	Route::post('/product/export', 'ProductController@export');
	Route::post('/product/{id}', 'ProductController@update');
	Route::post('/product/delete/{id}', 'ProductController@delete');

	Route::get('/production', 'ProductionController@index');
	Route::get('/production/data', 'ProductionController@data');
	Route::post('/production', 'ProductionController@create');
	Route::post('/production/export', 'ProductionController@export');
	Route::post('/production/{id}', 'ProductionController@update');
	Route::post('/production/delete/{id}', 'ProductionController@delete');

	Route::get('/transfer', 'TransferController@index');
	Route::get('/transfer/data', 'TransferController@data');
	Route::get('/transfer/detail', 'TransferController@detail');
	Route::post('/transfer', 'TransferController@create');
	Route::post('/transfer/export', 'TransferController@export');
	Route::post('/transfer/{id}', 'TransferController@update');
	Route::post('/transfer/delete/{id}', 'TransferController@delete');

	Route::get('/receipt', 'ReceiptController@index');
	Route::get('/receipt/data', 'ReceiptController@data');
	Route::get('/receipt/detail', 'ReceiptController@detail');
	Route::post('/receipt', 'ReceiptController@create');
	Route::post('/receipt/export', 'ReceiptController@export');
	Route::post('/receipt/{id}', 'ReceiptController@update');
	Route::post('/receipt/delete/{id}', 'ReceiptController@delete');

	Route::get('/allocation', 'AllocationController@index');
	Route::get('/allocation/data', 'AllocationController@data');
	Route::get('/allocation/detail', 'AllocationController@detail');
	Route::post('/allocation', 'AllocationController@create');
	Route::post('/allocation/export', 'AllocationController@export');
	Route::post('/allocation/{id}', 'AllocationController@update');
	Route::post('/allocation/delete/{id}', 'AllocationController@delete');

	Route::get('/delivery', 'DeliveryController@index');
	Route::get('/delivery/data', 'DeliveryController@data');
	Route::get('/delivery/detail', 'DeliveryController@detail');
	Route::post('/delivery', 'DeliveryController@create');
	Route::post('/delivery/export', 'DeliveryController@export');
	Route::post('/delivery/{id}', 'DeliveryController@update');
	Route::post('/delivery/delete/{id}', 'DeliveryController@delete');

	Route::get('/stock', 'StockController@index');
	Route::get('/stock/data', 'StockController@data');
	Route::post('/stock', 'StockController@create');
	Route::post('/stock/export', 'StockController@export');
	Route::post('/stock/{id}', 'StockController@update');
	Route::post('/stock/delete/{id}', 'StockController@delete');
});