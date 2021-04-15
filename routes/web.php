<?php

Route::get('', 'PageController@showIndex')->name('index');

Route::group(['prefix' => 'admin'], function () {
    Route::get('', 'PageController@adminIndex')->middleware('auth:5')->name('admin-index');
    Route::get('tours', 'TourController@showAll')->middleware('auth:5')->name('tours');
    Route::get('tours/create', 'TourController@showCreateForm')->middleware('auth:5')->name('create-form-tour');
    Route::get('tours/update/{id}', 'TourController@showEditForm')->middleware('auth:5')->name('edit-form-tour');
});
