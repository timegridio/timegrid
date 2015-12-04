<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

///////////////
// API CALLS //
///////////////

Route::group(['prefix' => 'api', 'middleware' => ['auth']], function () {

    Route::controller('booking', 'BookingController', ['postAction' => 'api.booking.action']);

    Route::group(['prefix' => 'services'], function () {

        Route::get('list/{business}', function ($business) {
            return $business->services()->lists('name', 'id');
        });

        Route::get('duration/{service}', function ($service) {
            return $service->duration;
        });
    });
});

//////////////////
// USER CONTEXT //
//////////////////

Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'User', 'middleware' => ['auth']], function () {

    //////////////
    // BOOKINGS //
    //////////////
    Route::group(['prefix' => 'booking', 'as' => 'booking.'], function () {

        Route::post('store', ['as' => 'store', 'uses' => 'AgendaController@postStore']);
        Route::get('bookings', ['as' => 'list', 'uses' => 'AgendaController@getIndex']);
        Route::get('book/{business}', ['as' => 'book', 'uses' => 'AgendaController@getAvailability']);
    });

    ////////////////
    // BUSINESSES //
    ////////////////
    Route::group(['prefix' => 'businesses', 'as' => 'businesses.'], function () {

        Route::get('home/{business}', ['as' => 'home', 'uses' => 'BusinessController@getHome']);
        Route::get('list', ['as' => 'list', 'uses' => 'BusinessController@getList']);
        Route::get('subscriptions', ['as' => 'subscriptions', 'uses' => 'BusinessController@getSubscriptions']);
    });

    ////////////
    // WIZARD //
    ////////////
    Route::group(['prefix' => 'wizard', 'as' => 'wizard.'], function () {
        Route::get('terms', ['as' => 'terms',   'uses' => 'WizardController@getTerms']);
        Route::get('wizard', ['as' => 'welcome', 'uses' => 'WizardController@getWelcome']);
        Route::get('pricing', ['as' => 'pricing', 'uses' => 'WizardController@getPricing']);
    });

});

/////////////////////////////////////////////////////////////
// USER RESOURCES                                          //
// ToDo: Needs to get moved into group as explicit routing //
/////////////////////////////////////////////////////////////

Route::group(['as' => 'user.', 'namespace' => 'User', 'middleware' => ['auth']], function () {

    Route::resource('business.contact', 'BusinessContactController');
});

/////////////////////
// MANAGER CONTEXT //
/////////////////////

Route::group(['prefix' => 'manager', 'namespace' => 'Manager', 'middleware' => ['auth']], function () {
    
    Route::controller('agenda/{business}', 'BusinessAgendaController', ['getIndex' => 'manager.business.agenda.index']);

    Route::post('search', ['uses' => 'BusinessController@postSearch']);

    Route::get('business/{business}/preferences', [
        'as' => 'manager.business.preferences',
        'uses' => 'BusinessPreferencesController@getPreferences'
        ]);
    
    Route::post('business/{business}/preferences', [
        'as' => 'manager.business.preferences',
        'uses' => 'BusinessPreferencesController@postPreferences'
        ]);
    
    Route::resource('business', 'BusinessController');

    Route::get('business/{business}/contact/import', [
        'as' => 'manager.business.contact.import',
        'uses' => 'BusinessContactImportExportController@getImport'
        ]);
    
    Route::post('business/{business}/contact/import', [
        'as' => 'manager.business.contact.import',
        'uses' => 'BusinessContactImportExportController@postImport'
        ]);
    
    Route::resource('business.contact', 'BusinessContactController');
    
    Route::resource('business.service', 'BusinessServiceController');
    
    Route::resource('business.vacancy', 'BusinessVacancyController');
});

Route::get('about/{business}', ['as' => 'guest.business.home', 'uses' => 'Guest\BusinessController@getHome']);

//////////////////
// ROOT CONTEXT //
//////////////////

Route::group([
    'prefix'=> 'root',
    'as' => 'root.',
    'namespace' => 'Root',
    'middleware' => ['auth', 'role:root']
    ],
    function () {
        Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'RootController@getIndex']);

        Route::get('sudo/{userId}', ['as' => 'sudo', 'uses' => 'RootController@getSudo'])->where('userId', '\d*');
    });

///////////////////////
// LANGUAGE SWITCHER //
///////////////////////

Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);

//////////////////
// REGULAR AUTH //
//////////////////

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

/////////////////
// SOCIAL AUTH //
/////////////////

Route::get('social/login/redirect/{provider}', [
    'as' => 'social.login',
    'uses' => 'Auth\OAuthController@redirectToProvider'
    ]);

Route::get('social/login/{provider}', 'Auth\OAuthController@handleProviderCallback');

///////////////////////////
// PRIVATE HOME / WIZARD //
///////////////////////////

Route::get('home', ['as' => 'home', 'uses' => 'User\WizardController@getWizard']);

/////////////////
// PUBLIC HOME //
/////////////////

Route::get('/', 'WelcomeController@index');

///////////////////////
// BUSINESS SELECTOR //
///////////////////////

Route::get('{business_slug}', function ($business_slug) {
    
    if ($business_slug->isEmpty()) {
        Flash::warning(trans('user.businesses.list.alert.not_found'));
        return Redirect::route('user.businesses.list');
    }

    $context = Auth::check() ? 'user' : 'guest';

    return Redirect::route("{$context}.business.home", $business_slug->first()->id);

})->where('business_slug', '[^_]+.*'); /* Underscore starter is reserved for debugging facilities */
