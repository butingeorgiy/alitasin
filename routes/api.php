<?php

Route::group(['prefix' => 'auth'], function () {
    Route::post('send-code', 'Api\AuthenticationController@sendSmsCode');
    Route::post('login', 'Api\AuthenticationController@login');
});

Route::group(['prefix' => 'users'], function () {
    Route::post('update/profile-photo', 'Api\UserController@uploadProfilePhoto')->middleware('auth:1');
    Route::post('create', 'Api\UserController@create');
    Route::post('update', 'Api\UserController@update')->middleware('auth:1');
});

Route::group(['prefix' => 'tours', 'middleware' => 'auth:5'], function () {
    Route::post('create', 'Api\TourController@create');
    Route::post('update/{tourId}/change-main-image', 'Api\TourController@changeMainImage');
    Route::post('update/{tourId}/remove-image', 'Api\TourController@deleteImage');
    Route::post('update/{tourId}/upload-image', 'Api\TourController@uploadImage');
    Route::post('update/{id}', 'Api\TourController@update');
});

Route::post('tours/reserve/{tourId}', 'Api\TourController@reserve');

Route::get('promo-codes/check', 'Api\PromoCodeController@get');

Route::get('tours', 'Api\TourController@get');
