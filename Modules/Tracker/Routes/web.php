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

Route::prefix('tracker')->group(function() {
    Route::get('/', 'TrackerController@index')->name('tracker::index');
    Route::get('/{order}', 'TrackerController@status')->name('tracker::status');
    Route::get('/order/{order}', 'TrackerController@etsyOrder')->name('tracker::order');

    Route::get('download/{order}', 'TrackerController@download')->name('tracker::download');
});