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

// Route::get('/user', function () {
//     return Auth::user();
// })->name('user');


Route::post('/register', 'Auth\RegisterController@register')->name('register');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/resetPassword', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::post('/app_search', 'AppController@search');
Route::get('/app_index', 'AppController@index');
Route::post('/app_create', 'AppController@store');
Route::post('/app_edit/{id}', 'AppController@update');
Route::post('/edit_infra/{id}', 'AppController@editInfra');
Route::post('/app_delete', 'AppController@delete');