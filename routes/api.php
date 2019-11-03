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


Route::get('/app_index', 'AppController@index');
Route::post('/app_create', 'AppController@store');
Route::post('/app_edit/{id}', 'AppController@update');
Route::delete('/app_delete/{id}', 'AppController@delete');