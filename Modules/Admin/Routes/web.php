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

Route::prefix('admin')->middleware('admin')->group(function() {
    Route::get('/', 'AdminController@index')->name('admin::index');

    // Orders
    Route::get('/orders', 'OrderController@index')->name('admin::orders');
    Route::get('/orders/completed', 'OrderController@completedOrders')->name('admin::orders.completed');
    Route::post('/orders/{order}/delete', 'OrderController@destroy')->name('admin::orders.delete');
    Route::post('/orders/{order}/edit', 'OrderController@update')->name('admin::orders.edit');
    Route::post('/orders/upload', 'OrderController@uploadFile')->name('admin::orders.upload');
    Route::post('/orders/process', 'OrderController@processOrder')->name('admin::orders.process');
    Route::get('/orders/{order}/comments', 'OrderController@retrieveComments')->name('admin::orders.comments');

    // Order Chunk Uploader
    Route::get('/orders/chunk', 'ChunkUploaderController@index')->name('admin::orders.chunk');
    Route::post('/orders/chunk/upload', 'ChunkUploaderController@store')->name('admin::orders.chunk.upload');

    // PosterSizes
    Route::get('invoice', 'PosterSizeController@index')->name('admin::invoice');
    
    Route::post('/poster-size/store', 'PosterSizeController@store')->name('admin::poster-size.store');
    Route::post('/poster-size/{id}/update', 'PosterSizeController@update')->name('admin::poster-size.update');
    Route::post('/poster-size/{id}/destroy', 'PosterSizeController@destroy')->name('admin::poster-size.destroy');

    Route::post('/shipping-method/store', 'ShippingMethodController@store')->name('admin::shipping-method.store');
    Route::post('/shipping-method/{id}/update', 'ShippingMethodController@update')->name('admin::shipping-method.update');
    Route::post('/shipping-method/{id}/destroy', 'ShippingMethodController@destroy')->name('admin::shipping-method.destroy');

    // OrderComments
    Route::post('/orders/{order}/comment/create', 'OrderCommentController@store')->name('admin::orders.comment.create');

    // Status Messages
    Route::post('/orders/status/create', 'StatusMessageController@store')->name('admin::status.create');

    // Templates
    Route::get('/templates', 'TemplateController@index')->name('admin::templates');
    Route::post('/templates/store', 'TemplateController@store')->name('admin::templates.create');
    Route::post('/templates/listing', 'TemplateController@attachTemplateListing')->name('admin::templates.listing');
    Route::get('/templates/{id}/preview', 'TemplateController@downloadPreview')->name('admin::templates.preview');

    Route::post('/preview/generate', 'TemplateController@generateListingPreview')->name('admin::preview.generate');
 Route::get('/templates/delete/{id}', 'TemplateController@deleteTemplate')->name('admin::templates.delete');
    // Etsy Listings
    Route::get('/listings', 'Etsy\ListingsController@index')->name('admin::etsy.listings');
    Route::post('/listings/edit', 'Etsy\ListingsController@update')->name('admin::etsy.listings.edit');

    Route::get('/backgrounds', 'BackgroundImageController@index')->name('admin::backgrounds');
    Route::post('/backgrounds/create', 'BackgroundImageController@store')->name('admin::backgrounds.create');
    Route::post('/backgrounds/edit', 'BackgroundImageController@update')->name('admin::backgrounds.edit');
    Route::post('/backgrounds/delete', 'BackgroundImageController@destroy')->name('admin::backgrounds.delete');

     /*Sizes */
    Route::get('/sizes', 'SizesController@index')->name('admin::sizes');
    Route::get('/sizes/create', 'SizesController@create')->name('admin::sizes.create');
    Route::get('/sizes/edit/{id}', 'SizesController@edit')->name('admin::sizes.edit');
    Route::post('/sizes/store', 'SizesController@store')->name('admin::sizes.store');
    Route::post('/sizes/update/{id}', 'SizesController@update')->name('admin::sizes.update');
    Route::get('/sizes/delete/{id}', 'SizesController@delete')->name('admin::sizes.delete');
    
    Route::get('/image-links', 'ImageLinksController@index')->name('admin::imagelinks');
    Route::get('/image-links/delete/{id}', 'ImageLinksController@delete')->name('admin::imagelinks.delete');
    Route::get('/image-links/edit/{id}', 'ImageLinksController@edit')->name('admin::imagelinks.edit');
    Route::post('/image-links/update/{id}', 'ImageLinksController@update')->name('admin::imagelinks.update');

    /*Custom Order Detail Page*/
    Route::get('/custom-orders', 'CustomOrdersController@index')->name('admin::custom-order');
    Route::get('/custom-orders/completed', 'CustomOrdersController@listCompletedOrders')->name('admin::custom-order.completed');
    Route::get('/custom-orders/mark-complete/{id}', 'CustomOrdersController@markAsCompleted')->name('admin::custom-order.mark-complete');
    Route::get('/custom-orders/delete/{id}', 'CustomOrdersController@delete')->name('admin::custom-order.delete');
    Route::get('/custom-orders/completed-delete/{id}', 'CustomOrdersController@deleteCompletedOrder')->name('admin::custom-order.completed-delete');


});
