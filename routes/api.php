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

Route::namespace('API')->group(function () {
    Route::namespace('Candidate')->group(function () {
        Route::get('candidate', 'ProfileController@index');
        Route::patch('candidate/{candidate}', 'ProfileController@update');
    });

    Route::namespace('Laravolt')->group(function () {
        Route::apiResource('provinces', 'ProvinceController')->except('show');
    });
});
