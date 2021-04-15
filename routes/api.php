<?php

Route::group(['prefix' => 'auth'], function () {
    Route::post('send-code', 'Api\AuthenticationController@sendSmsCode');
    Route::post('login', 'Api\AuthenticationController@login');
});

Route::group(['prefix' => 'users'], function () {
    Route::post('create', 'Api\UserController@create');
//    Route::post('update', 'Api\UserController@update');
    Route::post('update/{id?}', 'Api\UserController@update');
});

Route::group(['prefix' => 'tours', 'middleware' => 'auth:5'], function () {
    Route::post('create', 'Api\TourController@create');
    Route::post('update/{tourId}/change-main-image', 'Api\TourController@changeMainImage');
    Route::post('update/{tourId}/remove-image', 'Api\TourController@deleteImage');
    Route::post('update/{tourId}/upload-image', 'Api\TourController@uploadImage');
    Route::post('update/{id}', 'Api\TourController@update');
});

Route::get('tours', 'Api\TourController@get');
