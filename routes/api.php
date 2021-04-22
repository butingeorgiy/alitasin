<?php

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Api\AuthenticationController@login');
    Route::post('reg', 'Api\AuthenticationController@reg');
});

Route::group(['prefix' => 'users'], function () {
    Route::post('update/profile-photo', 'Api\UserController@uploadProfilePhoto')->middleware('auth:1,2,3,4,5');
    Route::post('update', 'Api\UserController@update')->middleware('auth:1');
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

});

Route::get('promo-codes/check', 'Api\PromoCodeController@get');
