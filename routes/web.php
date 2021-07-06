<?php

Route::get('', 'PageController@showIndex')->name('index');
Route::get('logout', 'AuthenticationController@logout')->name('logout');
Route::get('regions/{id}', 'PageController@showRegion')->name('region');
Route::get('tours/{id}', 'PageController@showTour')->name('tour');
Route::get('vehicles', 'PageController@showVehicles')->name('vehicles');

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
    Route::get('vehicles/create', 'VehicleController@showCreateForm')->middleware('auth:5')->name('create-vehicle');
    Route::get('vehicles/update/{id}', 'VehicleController@showEditForm')->middleware('auth:5')->name('edit-vehicle');
});

Route::get('cdn/images/{dir}/{file}', 'ImageController@get')->middleware('cache')->name('get-image');

Route::get('generate-pdf', function () {
    $pdf = App::make('dompdf.wrapper');
    $pdf->loadView('pdf.reservation-ticket')->setPaper([0, 0, 420, 900], 'landscape');
    return $pdf->stream();
});
