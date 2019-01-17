<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/setup', 'HomeController@setup')->name('setup');
Route::post('/setup/profile', 'SetupController@profile')->name('setup.profile');
Route::post('/setup/dapil', 'SetupController@dapil')->name('setup.dapil');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('{path}', 'HomeController@index')->where('path', '([A-z\d-\/_.]+)?');
