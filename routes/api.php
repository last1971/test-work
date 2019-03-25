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

Route::prefix('news')->group(function () {
    Route::post('update', 'MeduzaNewController@update');
    Route::middleware('day.check')->get('list', 'MeduzaNewController@list');
    Route::get('image/{type}/{year}/{month}/{day}/{id}', 'MeduzaNewController@image');
    Route::get('image/{type}/{id}', 'MeduzaNewController@image');
});