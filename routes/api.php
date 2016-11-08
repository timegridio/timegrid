<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

////////////////
// AJAX CALLS //
////////////////

// TODO: 'booking' should be moved out of api into the proper group.

Route::post('booking', [
    'as'   => 'api.booking.action',
    'uses' => 'BookingController@postAction',
]);

Route::get('vacancies/{businessId}/{serviceId}', [
    'uses' => 'AvailabilityController@getDates',
]);

Route::get('vacancies/{businessId}/{serviceId}/{date}', [
    'uses' => 'AvailabilityController@getTimes',
]);

Route::get('ical/{business}/{token}', [
    'as' => 'api.business.ical.download',
    'uses' => 'ICalController@download',
]);
