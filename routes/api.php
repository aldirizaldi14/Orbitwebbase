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
Route::post('/login', 'Api\LoginController@login');

Route::group(['middleware' => ['auth:api']], function () {
	Route::post('/warehouse/data', 'Api\WarehouseController@data');
	Route::post('/warehouse/sync', 'Api\WarehouseController@sync');
	Route::post('/area/data', 'Api\AreaController@data');
	Route::post('/line/data', 'Api\LineController@data');
	Route::post('/product/data', 'Api\ProductController@data');
	Route::post('/production/data', 'Api\ProductionController@data');
	Route::post('/production/sync', 'Api\ProductionController@sync');
	Route::post('/transfer/data', 'Api\TransferController@data');
	Route::post('/transfer/detail', 'Api\TransferController@detail');
	Route::post('/transfer/sync', 'Api\TransferController@sync');
	Route::post('/receipt/data', 'Api\ReceiptController@data');
	Route::post('/receipt/detail', 'Api\ReceiptController@detail');
	Route::post('/receipt/sync', 'Api\ReceiptController@sync');
	Route::post('/qty/data', 'Api\QtyController@data');

	Route::post('/last_update', function () { return date('Y-m-d H:i:s'); });
});
Route::fallback(function(){
    return response()->json(['message' => 'Not Found.'], 404);
})->name('api.fallback.404');