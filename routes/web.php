<?php

Route::get('', 'PageController@showIndex')->name('index');
Route::get('logout', 'AuthenticationController@logout')->name('logout');
Route::get('regions/{id}', 'PageController@showRegion')->name('region');
Route::get('tours/{id}', 'PageController@showTour')->name('tour');

Route::get('profile/client', 'PageController@showClientProfile')
    ->middleware('auth:1')
    ->name('client-profile');

Route::group(['prefix' => 'profile'], function () {
    Route::get('', 'PageController@profileIndex')->middleware('auth:1,2')->name('profile-index');
    Route::get('client', 'PageController@showClientProfile')->middleware('auth:1')->name('client-profile');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('', 'PageController@adminIndex')->middleware('auth:3,4,5')->name('admin-index');
    Route::get('tours', 'TourController@showAll')->middleware('auth:5')->name('tours');
    Route::get('tours/create', 'TourController@showCreateForm')->middleware('auth:5')->name('create-form-tour');
    Route::get('tours/update/{id}', 'TourController@showEditForm')->middleware('auth:5')->name('edit-form-tour');
});

Route::get('cdn/images/{dir}/{file}', 'ImageController@get')->middleware('cache')->name('get-image');
