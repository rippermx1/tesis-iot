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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('dispositivos', 'DispositivosController@getAll');
Route::get('dispositivo/{id}', 'DispositivosController@getById');
Route::get('dispositivo/{pin}/estado', 'DispositivosController@getMicroControllerPinStatus');
Route::get('dispositivo/{pin}/encendido/{encendido}/luminosidad/{luminosidad}', 'DispositivosController@syncDevice');
Route::get('dispositivo/{pin}/{estado}', 'DispositivosController@updateDevice');
Route::post('dispositivo', 'DispositivosController@create');
