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

Route::get('/fix', function(){
	Artisan::call('storage:link');
	Artisan::call('migrate');
	echo Artisan::output();
});

Route::get('/test', function(){
	return view('mails.poster-shipped');
});

Auth::routes();