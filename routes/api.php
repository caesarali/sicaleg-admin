<?php

Route::post('/login', 'API\Auth\LoginController@login');
Route::namespace('API\v1')->middleware('auth:api')->group(function () {
    Route::get('/dashboard', 'DashboardController@index');

    Route::apiResource('party', 'Candidate\PartyController')->only(['index', 'update']);
    Route::namespace('Candidate')->prefix('candidate')->group(function () {
        Route::apiResource('profile', 'ProfileController')->only(['index', 'update']);
        Route::apiResource('dapil', 'DapilController')->only(['index', 'store', 'destroy']);
    });

    Route::namespace('Monitoring')->prefix('monitoring')->group( function () {
        Route::get('/', 'VolunteerController@index');
        Route::get('/activities', 'VolunteerController@activities');
        Route::get('/top-volunteers', 'VolunteerController@topVolunteers');
    });

    Route::namespace('Election')->group(function () {
        Route::post('dpt/import', 'DptController@import');
        Route::apiResource('dpt', 'DptController')->only(['index', 'store', 'update', 'destroy']);
        Route::apiResource('tps', 'TpsController')->only(['store', 'destroy']);
        Route::apiResource('supporters', 'SupporterController')->only(['index', 'destroy']);
    });

    Route::namespace('Team')->group(function () {
        Route::apiResource('volunteers', 'VolunteerController');
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

Route::post('/v2/login', 'API\Auth\LoginController@login');
Route::namespace('API\v2')->prefix('v2')->middleware('auth:api')->group(function () {
    Route::get('/candidate', 'CandidateController@index');
    Route::get('/voter/{nik}', 'VoterController@search');
    Route::get('/dashboard', 'SupporterController@monitor');
    Route::apiResource('supporters', 'SupporterController')->only(['index', 'store', 'destroy']);
});
