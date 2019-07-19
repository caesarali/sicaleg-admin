<?php

Route::get('/', function () {
    return view('welcome');
});

// Route::get('test', function () {
//     $district = App\Models\District::find(7315080);
//     dd($district, $district->villages->pluck('name'));
// });

Auth::routes();

Route::get('/setup', 'HomeController@setup')->name('setup');
Route::post('/setup/profile', 'SetupController@profile')->name('setup.profile');
Route::post('/setup/dapil', 'SetupController@dapil')->name('setup.dapil');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/{any}', 'HomeController@index')->where('any', '.*');
