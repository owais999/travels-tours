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

use Illuminate\Support\Facades\Route;
// FLight
Route::group(['prefix' => env('FLIGHT_ROUTE_PREFIX', 'flight')], function () {
    Route::get('/', 'FlightController@index')->name('flight.search'); // Search
    Route::get('/{slug}', 'FlightController@detail')->name('flight.detail'); // Detail
});
// Vendor Manage Flight
Route::group(['prefix' => 'user/' . config('flight.flight_route_prefix'), 'middleware' => ['auth', 'verified']], function () {
    Route::match(['get',], '/', 'ManageFlightController@manageFlight')->name('flight.vendor.index');
    Route::match(['get',], '/create', 'ManageFlightController@createFlight')->name('flight.vendor.create');
    Route::match(['get',], '/edit/{slug}', 'ManageFlightController@editFlight')->name('flight.vendor.edit');
    Route::match(['get', 'post'], '/del/{slug}', 'ManageFlightController@deleteFlight')->name('flight.vendor.delete');
    Route::match(['post'], '/store/{slug}', 'ManageFlightController@store')->name('flight.vendor.store');
    Route::get('bulkEdit/{id}', 'ManageFlightController@bulkEditFlight')->name("flight.vendor.bulk_edit");
    Route::get('clone/{id}', 'ManageFlightController@cloneFlight')->name("flight.vendor.clone");
    Route::get('/booking-report', 'ManageFlightController@bookingReport')->name("flight.vendor.booking_report");
    Route::get('/booking-report/bulkEdit/{id}', 'ManageFlightController@bookingReportBulkEdit')->name("flight.vendor.booking_report.bulk_edit");
});
Route::group(['prefix' => 'user/' . config('flight.flight')], function () {
    Route::group(['prefix' => 'availability'], function () {
        Route::get('/', 'AvailabilityController@index')->name('flight.vendor.availability.index');
        Route::get('/loadDates', 'AvailabilityController@loadDates')->name('flight.vendor.availability.loadDates');
        Route::match(['get', 'post'], '/store', 'AvailabilityController@store')->name('flight.vendor.availability.store');
    });
});
// // FLight
// Route::group(['prefix' => config('flight.flight_route_prefix')], function () {
//     Route::get('/', '\Modules\Flight\Controllers\FlightController@index')->name('flight.search'); // Search
//     Route::get('/{slug}', '\Modules\Flight\Controllers\FlightController@detail')->name('flight.detail'); // Detail

// });
