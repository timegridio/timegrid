<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['prefix' => 'api', 'middleware' => ['auth']], function () {
    
    Route::group(['prefix' => 'services'], function () {
        
        Route::get('list/{business}', function ($business) {
            return $business->services()->lists('name', 'id');
        });
        
        Route::get('duration/{service}', function ($service) {
            return $service->duration;
        });
    });
});

Route::get('home', ['as' => 'home', 'uses' => 'User\BusinessController@getList']);

Route::group(['prefix' => 'user', 'namespace' => 'User', 'middleware' => ['auth']], function () {
    Route::group(['prefix' => 'booking'], function () {
        Route::get('book',      ['as' => 'user.booking.book', 'uses' => 'BookingController@getBook']);
        Route::get('bookings',  ['as' => 'user.booking.list', 'uses' => 'BookingController@getIndex']);
        Route::post('store',    ['as' => 'user.booking.store', 'uses' => 'BookingController@postStore']);
    });

    Route::group(['prefix' => 'businesses'], function () {
        Route::get('home',                   ['as' => 'user.businesses.home', 'uses' => 'BusinessController@getHome']);
        Route::get('select/{business_slug}', ['as' => 'user.businesses.select', 'uses' => 'BusinessController@getSelect']);
        Route::get('list',                   ['as' => 'user.businesses.list', 'uses' => 'BusinessController@getList']);
        Route::get('suscriptions',           ['as' => 'user.businesses.suscriptions', 'uses' => 'BusinessController@getSuscriptions']);
    });

    Route::resource('business.contact', 'BusinessContactController');
});

Route::group(['prefix' => 'manager', 'namespace' => 'Manager', 'middleware'    => ['auth']], function () {
    Route::resource('business', 'BusinessesController');
    Route::resource('business.contact', 'BusinessContactController');
    Route::resource('business.service', 'BusinessServiceController');
    Route::resource('business.vacancy', 'BusinessVacancyController');
    Route::get('{business}/agenda',      ['as' => 'manager.business.agenda.index', 'uses' => 'BusinessAgendaController@getIndex']);
});

Route::get('root', [
    'as'            => 'root',
    'uses'          => 'RootController@index',
    'middleware'    => ['auth', 'acl'],
    'is'            => 'root']
);

Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

# Route::get('{search}', function ($search) {
#     return Redirect::route('user.businesses.select', $search);
# })->where('search', '.*');

Route::get('/', 'WelcomeController@index');
