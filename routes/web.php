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
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/warehouse', 'WarehouseController@index');
Route::get('/warehouse/data', 'WarehouseController@data');
Route::post('/warehouse', 'WarehouseController@create');
Route::post('/warehouse/export', 'WarehouseController@export');
Route::post('/warehouse/{id}', 'WarehouseController@update');
Route::delete('/warehouse/{id}', 'WarehouseController@delete');

Route::get('/last_update', function () {
    return date('Y-m-d H:i:s');
});