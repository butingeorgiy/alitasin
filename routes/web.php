<?php
use Illuminate\Support\Facades\Route;

Route::get('', 'PageController@showIndex')->name('index');
Route::get('logout', 'AuthenticationController@logout')->name('logout');
Route::get('regions/{id}', 'PageController@showRegion')->name('region');
Route::get('tours/{id}', 'PageController@showTour')->name('tour');
Route::get('vehicles', 'PageController@showVehicles')->name('vehicles');
Route::get('transfers', 'PageController@showTransfers')->name('transfers');
Route::get('property', 'PageController@showProperty')->name('property');
Route::get('partnership', 'PageController@showPartnership')->name('partnership');

Route::group(['prefix' => 'profile'], function () {
    Route::get('', 'PageController@profileIndex')->middleware('auth:1,2')->name('profile-index');
    Route::get('client', 'PageController@showClientProfile')->middleware('auth:1')->name('client-profile');
    Route::get('partner', 'PageController@showPartnerProfile')->middleware('auth:2')->name('partner-profile');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('', 'PageController@adminIndex')->middleware('auth:3,4,5')->name('admin-index');

    Route::get('tours', 'TourController@showAll')->middleware('auth:3,5')->name('tours');
    Route::get('tours/create', 'TourController@showCreateForm')->middleware('auth:5')->name('create-form-tour');
    Route::get('tours/update/{id}', 'TourController@showEditForm')->middleware('auth:3,5')->name('edit-form-tour');

    Route::get('reserves', 'ReservationController@showAll')->middleware('auth:4')->name('reserves');

    Route::get('partners', 'PartnerController@showAll')->middleware('auth:5')->name('partners');
    Route::get('partners/{id}', 'PartnerController@show')->middleware('auth:5')->name('partner');

    Route::group(['prefix' => 'vehicles'], function () {
        Route::get('create', 'VehicleController@showCreateForm')->middleware('auth:5')->name('create-vehicle');
        Route::get('update/{id}', 'VehicleController@showEditForm')->middleware('auth:5')->name('edit-vehicle');
    });

    Route::group(['prefix' => 'properties'], function () {
        Route::get('create', 'PropertyController@showCreateForm')->middleware('auth:5')->name('create-property');
        Route::get('update/{id}', 'PropertyController@showEditForm')->middleware('auth:5')->name('edit-property');
    });

    Route::get('transfers', 'TransferController@showEditForm')->middleware('auth:5')->name('edit-transfers');
});

Route::get('cdn/images/{dir}/{file}', 'ImageController@get')->middleware('cache')->name('get-image');