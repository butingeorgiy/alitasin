<?php

Route::middleware('cache.headers:private;max_age=3600')->group(function () {
    Route::get('', 'PageController@showIndex')->name('index');
    Route::get('regions/{id}', 'PageController@showRegion')->name('region');
    Route::get('/tours/{id}', 'PageController@showTour')->name('tour');

    Route::group(['prefix' => 'admin'], function () {
        Route::get('', 'PageController@adminIndex')->middleware('auth:5')->name('admin-index');
        Route::get('tours', 'TourController@showAll')->middleware('auth:5')->name('tours');
        Route::get('tours/create', 'TourController@showCreateForm')->middleware('auth:5')->name('create-form-tour');
        Route::get('tours/update/{id}', 'TourController@showEditForm')->middleware('auth:5')->name('edit-form-tour');
    });

    Route::get('cdn/images/{fileName}', 'ImageController@get')->name('get-image');
});
