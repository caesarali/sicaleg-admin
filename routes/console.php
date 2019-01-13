<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('test', function () {
    $this->comment('Message');
})->describe('Test Command');

Artisan::command('sipileg:seed', function () {
    Artisan::call('db:seed', ['--class' => 'Laravolt\Indonesia\Seeds\DatabaseSeeder']);
    Artisan::call('db:seed');
    $this->comment('Data Seed SIPILEG berhasil ter-Init.');
});
