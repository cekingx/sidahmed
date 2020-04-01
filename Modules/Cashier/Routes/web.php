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

Route::get('/cart', 'CartController@index')->name('cart');

Route::get('/cart/checkout', 'CartController@checkout')->name('cart.checkout');
Route::post('/cart/edit', 'CartController@edit')->name('cart.edit');
Route::get('/cart/create-custom-order', 'CartController@saveCustomOrder')->name('cart.createCustomOrder');
Route::get('/cart/order-confirmed/{orderId}', 'CartController@orderConfimed')->name('cart.orderConfirmed');
Route::post('/order/send-order-code', 'CartController@sendOrderCodeEmail')->name('cart.sendOrderCodeEmail');
