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

Route::prefix('cities')->group(function() {
    Route::get('/', 'CitiesController@index')->name('cities::editor');
    Route::post('/process', 'CitiesController@addToCart')->name('cities::process');
    Route::get('/remove-cart/{id}', 'CitiesController@removeIteamCart')->name('cities::process.removeCart');
    Route::post('/process/etsy', 'CitiesController@handleEtsy')->name('cities::process.etsy');
    Route::get('/download/{token}', 'CitiesController@viewTempImage')->name('cities::download.tempImg');
    Route::any('/createLink', 'CitiesController@createTempLink')->name('cities::createTempLink');
    Route::get('order-poster/{id}', 'CitiesController@orderPosterEditor')->name('cities::order-poster');
});
    Route::get('/{templateId}', 'CitiesController@index')->name('cities::precreated-template');
