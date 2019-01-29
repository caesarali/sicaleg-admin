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

Route::get('/pretty-json', function () {
    $jsonString = file_get_contents(asset('dpt/listDps.json'));
    $data = json_decode($jsonString, true);
    dd($data);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('API')->group(function () {
    Route::apiResource('party', 'PartyController')->only(['index', 'update']);

    Route::namespace('Candidate')->prefix('candidate')->group(function () {
        Route::apiResource('profile', 'ProfileController')->only(['index', 'update']);
        Route::apiResource('locations', 'LocationsController')->only(['index', 'store', 'destroy']);
        Route::apiResource('dapil', 'DapilController')->only(['index', 'store', 'destroy']);
    });

    Route::namespace('Election')->group(function () {
        Route::apiResource('dpt', 'DptController')->only(['index', 'store', 'update', 'destroy']);
        Route::apiResource('tps', 'TpsController')->only(['store', 'destroy']);
    });

    Route::namespace('Team')->group(function () {
        Route::apiResource('volunteers', 'VolunteerController');
    });

    Route::namespace('Laravolt')->group(function () {
        Route::apiResource('provinces', 'ProvinceController')->except('show');
    });
});
