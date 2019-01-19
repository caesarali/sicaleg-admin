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
    Route::apiResource('party', 'PartyController')->only(['index', 'update']);

    Route::namespace('Candidate')->group(function () {
        Route::apiResource('candidate', 'ProfileController')->only(['index', 'update']);
        Route::apiResource('candidate/locations', 'LocationsController')->only(['index', 'store', 'destroy']);
    });

    Route::namespace('Laravolt')->group(function () {
        Route::apiResource('provinces', 'ProvinceController')->except('show');
    });
});
