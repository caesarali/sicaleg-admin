<?php

use Illuminate\Http\Request;

Route::post('/login', 'API\Auth\LoginController@login');

Route::namespace('API')->middleware('auth:api')->group(function () {
    Route::get('/dashboard', 'DashboardController@index');

    Route::apiResource('party', 'Candidate\PartyController')->only(['index', 'update']);
    Route::namespace('Candidate')->prefix('candidate')->group(function () {
        Route::apiResource('profile', 'ProfileController')->only(['index', 'update']);
        Route::apiResource('dapil', 'DapilController')->only(['index', 'store', 'destroy']);
    });

    Route::namespace('Election')->group(function () {
        Route::post('dpt/import', 'DptController@import');
        Route::apiResource('dpt', 'DptController')->only(['index', 'store', 'update', 'destroy']);
        Route::apiResource('tps', 'TpsController')->only(['store', 'destroy']);
        Route::apiResource('supporters', 'SupporterController');
    });

    Route::namespace('Team')->group(function () {
        Route::apiResource('volunteers', 'VolunteerController')->except(['show']);
        Route::apiResource('coordinators', 'CoordinatorController')->except(['show']);
    });

    Route::namespace('Laravolt')->group(function () {
        Route::apiResource('provinces', 'ProvinceController')->except('show');
    });

    Route::get('/city/{id}', function ($id) {
        return Indonesia::findCity($id, ['districts']);
    });
    Route::get('/district/{id}', function ($id) {
        return Indonesia::findDistrict($id, ['villages']);
    });

    Route::namespace('Auth')->group(function () {
        Route::apiResource('users', 'UserController')->except(['show']);
    });
});
