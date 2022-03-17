<?php

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Api\AuthenticationController@login');
    Route::post('reg', 'Api\AuthenticationController@reg');
});

Route::group(['prefix' => 'users'], function () {
    Route::post('update/profile-photo', 'Api\UserController@uploadProfilePhoto')->middleware('auth:1,2,3,4,5');
    Route::post('update', 'Api\UserController@update')->middleware('auth:1,2');
});

Route::group(['prefix' => 'partners'], function () {
    Route::post('create', 'Api\PartnerController@create')->middleware('auth:5');
    Route::post('delete/{id}', 'Api\PartnerController@delete')->middleware('auth:5');
    Route::post('restore/{id}', 'Api\PartnerController@restore')->middleware('auth:5');
    Route::post('make-payment/{id}', 'Api\PartnerController@makePayment')->middleware('auth:5');
    Route::post('update-profit-percent/{id}', 'Api\PartnerController@updateProfitPercent')->middleware('auth:5');
    Route::post('update/{id}', 'Api\PartnerController@update')->middleware('auth:5');
    Route::get('search', 'Api\PartnerController@search')->middleware('auth:5');
});

Route::group(['prefix' => 'tours'], function () {
    Route::get('', 'Api\TourController@get');
    Route::post('create', 'Api\TourController@create')->middleware('auth:5');
    Route::post('update/{tourId}/change-main-image', 'Api\TourController@changeMainImage')->middleware('auth:3,5');
    Route::post('update/{tourId}/remove-image', 'Api\TourController@deleteImage')->middleware('auth:3,5');
    Route::post('update/{tourId}/upload-image', 'Api\TourController@uploadImage')->middleware('auth:3,5');
    Route::post('update/{id}', 'Api\TourController@update')->middleware('auth:3,5');
    Route::post('delete/{id}', 'Api\TourController@delete')->middleware('auth:3,5');
    Route::post('reserve/{tourId}', 'Api\TourController@reserve');
    Route::post('toggle-favorite/{tourId}', 'Api\TourController@toggleFavorite')->middleware('auth:1');
});

Route::group(['prefix' => 'vehicles'], function() {
    Route::post('create', 'Api\VehicleController@create')->middleware('auth:5');
    Route::post('order/{id}', 'Api\VehicleController@order');
    Route::post('{id}/delete', 'Api\VehicleController@delete')->middleware('auth:5');
    Route::post('{id}/restore', 'Api\VehicleController@restore')->middleware('auth:5');
    Route::post('{id}/update', 'Api\VehicleController@update')->middleware('auth:5');
    Route::post('{vehicleId}/update/change-main-image', 'Api\VehicleController@changeMainImage')->middleware('auth:5');
    Route::post('{vehicleId}/update/remove-image', 'Api\VehicleController@deleteImage')->middleware('auth:5');
    Route::post('{vehicleId}/update/upload-image', 'Api\VehicleController@updateImage')->middleware('auth:5');
});

Route::group(['prefix' => 'reserves'], function () {
    Route::post('update/{reservationId}/status', 'Api\ReservationController@updateStatus')->middleware('auth:4');
});

Route::group(['prefix' => 'transfers'], function () {
    Route::get('destinations', 'Api\TransferController@getDestinations');
    Route::get('calculate', 'Api\TransferController@getCost');
    Route::post('requests/create', 'Api\TransferController@createRequest');
    Route::get('variations', 'Api\TransferController@getAvailableVariations')->middleware('auth:5');
    Route::post('{id}/update-cost', 'Api\TransferController@updateVariationCost')->middleware('auth:5');
    Route::post('{id}/delete-cost', 'Api\TransferController@deleteVariationCost')->middleware('auth:5');
    Route::get('check', 'Api\TransferController@isExists')->middleware('auth:5');
    Route::post('create', 'Api\TransferController@create')->middleware('auth:5');
    Route::post('{id}/delete', 'Api\TransferController@delete')->middleware('auth:5');
});

Route::group(['prefix' => 'airports'], function () {
    Route::get('', 'Api\AirportController@getAll');
    Route::post('create', 'Api\AirportController@create')->middleware('auth:5');
    Route::post('{id}/update', 'Api\AirportController@update')->middleware('auth:5');
    Route::post('{id}/delete', 'Api\AirportController@delete')->middleware('auth:5');
    Route::post('{id}/restore', 'Api\AirportController@restore')->middleware('auth:5');
});

Route::group(['prefix' => 'destinations'], function () {
    Route::get('', 'Api\TransferDestinationController@getAll');
    Route::post('create', 'Api\TransferDestinationController@create')->middleware('auth:5');
    Route::post('{id}/update', 'Api\TransferDestinationController@update')->middleware('auth:5');
    Route::post('{id}/delete', 'Api\TransferDestinationController@delete')->middleware('auth:5');
    Route::post('{id}/restore', 'Api\TransferDestinationController@restore')->middleware('auth:5');
});

Route::get('promo-codes/check', 'Api\PromoCodeController@get');
Route::post('telegram-bot/webhook', 'Api\TelegramBotController@webhook');
