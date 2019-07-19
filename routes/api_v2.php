<?php

use Illuminate\Http\Request;

Route::post('/login', 'API\Auth\LoginController@login');

Route::namespace('API\v2')->middleware('auth:api')->group(function () {

});
