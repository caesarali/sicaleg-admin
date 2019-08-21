<?php

Route::post('/login', 'API\v1\Auth\LoginController@login');
Route::namespace('API\v1')->middleware('auth:api')->group(function () {
    Route::get('/user', function () {
        return response()->json(auth('api')->user()->load('roles'));
    });
    Route::get('/notifications', function () {
        $notifications = auth('api')->user()->unreadNotifications;
        if (request()->markAs && request()->markAs == 'read') {
            foreach ($notifications as $notification) {
                $notification->markAsRead();
            }
        }
        return response()->json($notifications);
    });

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
        Route::post('/users/{user}/reset', 'UserController@reset');
        Route::apiResource('users', 'UserController')->except(['show']);
    });
});

Route::post('/v2/login', 'API\v2\LoginController@login');
Route::namespace('API\v2')->prefix('v2')->middleware('auth:api')->group(function () {
    Route::get('/candidate', 'CandidateController@index');
    Route::get('/voter/{nik}', 'VoterController@search');
    Route::get('/dashboard', 'SupporterController@monitor');
    Route::get('/profile', 'ProfileController@index');
    Route::post('/profile', 'ProfileController@save');
    Route::apiResource('supporters', 'SupporterController')->only(['index', 'store', 'destroy']);
});
