<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

////////////////
// AJAX CALLS //
////////////////

Route::group(['prefix' => 'api', 'middleware' => ['web', 'auth']], function () {

    // TODO: 'booking' should be moved out of api into the proper group.
    Route::post('booking', [
        'as'   => 'api.booking.action',
        'uses' => 'BookingController@postAction',
    ]);

    Route::get('vacancies/{businessId}/{serviceId}/{date}', [
        'uses' => 'BookingController@getTimes',
    ]);

});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

//////////////////
// ROOT CONTEXT //
//////////////////

Route::group(
    [
        'as'         => 'root.',
        'prefix'     => 'root',
        'namespace'  => 'Root',
        'middleware' => ['web', 'role:root'],
    ],
    function () {
        Route::get('dashboard', [
            'as'   => 'dashboard',
            'uses' => 'RootController@getIndex',
        ]);

        Route::get('sudo/{userId}', [
            'as'   => 'sudo',
            'uses' => 'RootController@getSudo',
        ])->where('userId', '\d*');
    }
);

//////////////////
// REGULAR AUTH //
//////////////////

Route::group(['prefix' => 'auth', 'middleware' => 'web', 'auth', 'as' => 'auth'], function () {
    Route::auth();
});

///////////////////
// GUEST CONTEXT //
///////////////////

Route::group(['middleware' => 'web', 'auth'], function () {

    ///////////////////////////
    // PRIVATE HOME / WIZARD //
    ///////////////////////////

    Route::get('home', ['as' => 'home', 'uses' => 'User\WizardController@getWizard']);

    ///////////////////////
    // LANGUAGE SWITCHER //
    ///////////////////////

    Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);

    /////////////////
    // SOCIAL AUTH //
    /////////////////

    Route::get('social/login/redirect/{provider}', [
        'as'   => 'social.login',
        'uses' => 'Auth\OAuthController@redirectToProvider',
    ]);

    Route::get('social/login/{provider}', 'Auth\OAuthController@handleProviderCallback');

    /////////////////
    // PUBLIC HOME //
    /////////////////

    Route::get('/', 'WelcomeController@index');
});

//////////////////
// USER CONTEXT //
//////////////////

Route::group(['prefix' => 'user', 'middleware' => ['web', 'auth']], function () {

    Route::get('agenda', [
        'as'   => 'user.agenda',
        'uses' => 'User\AgendaController@getIndex',
    ]);
    Route::get('businesses/register/{plan?}', [
        'as'   => 'manager.business.register',
        'uses' => 'Manager\BusinessController@create',
    ]);
    Route::post('businesses/register', [
        'as'   => 'manager.business.store',
        'uses' => 'Manager\BusinessController@store',
    ]);
    Route::get('businesses', [
        'as'   => 'manager.business.index',
        'uses' => 'Manager\BusinessController@index',
    ]);
    Route::get('directory', [
        'as'   => 'user.directory.list',
        'uses' => 'User\BusinessController@getList',
    ]);
    Route::get('subscriptions', [
        'as'   => 'user.subscriptions',
        'uses' => 'User\BusinessController@getSubscriptions',
    ]);
    Route::get('dashboard', [
        'as'   => 'user.dashboard',
        'uses' => 'User\WizardController@getDashboard',
    ]);

    ////////////
    // WIZARD //
    ////////////
    Route::group(['as' => 'wizard.'], function () {
        Route::get('terms', [
            'as'   => 'terms',
            'uses' => 'User\WizardController@getTerms',
        ]);
        Route::get('wizard', [
            'as'   => 'welcome',
            'uses' => 'User\WizardController@getWelcome',
        ]);
        Route::get('pricing', [
            'as'   => 'pricing',
            'uses' => 'User\WizardController@getPricing',
        ]);
    });

});

////////////////////////////////////
// SELECTED BUSINESS SLUG CONTEXT //
////////////////////////////////////

Route::group(['prefix' => '{business}', 'middleware' => ['web', 'auth']], function () {

    ///////////////////////////
    // BUSINESS USER CONTEXT //
    ///////////////////////////

    Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'User'], function () {

        // BOOKINGS
        Route::group(['prefix' => 'agenda', 'as' => 'booking.'], function () {
            Route::post('store', [
                'as'   => 'store',
                'uses' => 'AgendaController@postStore',
            ]);
            Route::get('book', [
                'as'   => 'book',
                'uses' => 'AgendaController@getAvailability',
            ]);
        });

        // BUSINESSES
        Route::group(['prefix' => 'businesses', 'as' => 'businesses.'], function () {
            Route::get('home', [
                'as'   => 'home',
                'uses' => 'BusinessController@getHome',
            ]);
        });

    });

    ////////////////////
    // USER RESOURCES //
    ////////////////////

    Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'User'], function () {

        Route::get('contact', [
            'as'   => 'business.contact.index',
            'uses' => 'ContactController@index',
        ]);
        Route::get('contact/create', [
            'as'   => 'business.contact.create',
            'uses' => 'ContactController@create',
        ]);
        Route::post('contact', [
            'as'   => 'business.contact.store',
            'uses' => 'ContactController@store',
        ]);
        Route::get('contact/{contact}', [
            'as'   => 'business.contact.show',
            'uses' => 'ContactController@show',
        ]);
        Route::get('contact/{contact}/edit', [
            'as'   => 'business.contact.edit',
            'uses' => 'ContactController@edit',
        ]);
        Route::put('contact/{contact}', [
            'as'   => 'business.contact.update',
            'uses' => 'ContactController@update',
        ]);
        Route::delete('contact/{contact}', [
            'as'   => 'business.contact.destroy',
            'uses' => 'ContactController@destroy',
        ]);
    });

    //////////////////////////////
    // BUSINESS MANAGER CONTEXT //
    //////////////////////////////

    Route::group(['prefix' => 'manage', 'namespace' => 'Manager'], function () {

        // BUSINESS PREFERENCES
        Route::get('preferences', [
            'as'   => 'manager.business.preferences',
            'uses' => 'BusinessPreferencesController@getPreferences',
            ]);
        Route::post('preferences', [
            'as'   => 'manager.business.preferences',
            'uses' => 'BusinessPreferencesController@postPreferences',
            ]);

        // AGENDA
        Route::get('agenda', [
            'as'   => 'manager.business.agenda.index',
            'uses' => 'BusinessAgendaController@getIndex',
        ]);
        Route::get('calendar', [
            'as'   => 'manager.business.agenda.calendar',
            'uses' => 'BusinessAgendaController@getCalendar',
        ]);

        // BUSINESS MANAGEMENT
        Route::get('dashboard', [
            'as'   => 'manager.business.show',
            'uses' => 'BusinessController@show',
        ]);
        Route::get('edit', [
            'as'   => 'manager.business.edit',
            'uses' => 'BusinessController@edit',
        ]);
        Route::put('', [
            'as'   => 'manager.business.update',
            'uses' => 'BusinessController@update',
        ]);
        Route::delete('', [
            'as'   => 'manager.business.destroy',
            'uses' => 'BusinessController@destroy',
        ]);

        // BUSINESS NOTIFICATIONS
        Route::get('notifications', [
            'as'   => 'manager.business.notifications.show',
            'uses' => 'BusinessNotificationsController@show',
            ]);

        // SEARCH
        Route::post('search', [
            'as'   => 'manager.search',
            'uses' => 'Search@postSearch',
        ]);

        // ADDRESSBOOK / CONTACT RESOURCE
        Route::group(['prefix' => 'contact'], function () {
            Route::get('', [
                'as'   => 'manager.addressbook.index',
                'uses' => 'AddressbookController@index',
            ]);
            Route::get('create', [
                'as'   => 'manager.addressbook.create',
                'uses' => 'AddressbookController@create',
            ]);
            Route::post('', [
                'as'   => 'manager.addressbook.store',
                'uses' => 'AddressbookController@store',
            ]);
            Route::get('{contact}', [
                'as'   => 'manager.addressbook.show',
                'uses' => 'AddressbookController@show',
            ]);
            Route::get('{contact}/edit', [
                'as'   => 'manager.addressbook.edit',
                'uses' => 'AddressbookController@edit',
            ]);
            Route::put('{contact}', [
                'as'   => 'manager.addressbook.update',
                'uses' => 'AddressbookController@update',
            ]);
            Route::delete('{contact}', [
                'as'   => 'manager.addressbook.destroy',
                'uses' => 'AddressbookController@destroy',
            ]);
        });

        // HUMAN RESOURCE
        Route::group(['prefix' => 'humanresources'], function () {

            Route::get('', [
                'as'   => 'manager.business.humanresource.index',
                'uses' => 'HumanresourceController@index',
            ]);
            Route::get('create', [
                'as'   => 'manager.business.humanresource.create',
                'uses' => 'HumanresourceController@create',
            ]);
            Route::post('', [
                'as'   => 'manager.business.humanresource.store',
                'uses' => 'HumanresourceController@store',
            ]);
            Route::get('{humanresource}', [
                'as'   => 'manager.business.humanresource.show',
                'uses' => 'HumanresourceController@show',
            ]);
            Route::get('{humanresource}/edit', [
                'as'   => 'manager.business.humanresource.edit',
                'uses' => 'HumanresourceController@edit',
            ]);
            Route::put('{humanresource}', [
                'as'   => 'manager.business.humanresource.update',
                'uses' => 'HumanresourceController@update',
            ]);
            Route::delete('{humanresource}', [
                'as'   => 'manager.business.humanresource.destroy',
                'uses' => 'HumanresourceController@destroy',
            ]);

        });

        // SERVICE RESOURCE
        Route::group(['prefix' => 'service'], function () {

            // SERVICE TYPE
            Route::group(['prefix' => 'type'], function () {
                Route::get('edit', [
                    'as'   => 'manager.business.servicetype.edit',
                    'uses' => 'ServiceTypeController@edit',
                ]);
                Route::put('', [
                    'as'   => 'manager.business.servicetype.update',
                    'uses' => 'ServiceTypeController@update',
                ]);
            });

            Route::get('', [
                'as'   => 'manager.business.service.index',
                'uses' => 'BusinessServiceController@index',
            ]);
            Route::get('create', [
                'as'   => 'manager.business.service.create',
                'uses' => 'BusinessServiceController@create',
            ]);
            Route::post('', [
                'as'   => 'manager.business.service.store',
                'uses' => 'BusinessServiceController@store',
            ]);
            Route::get('{service}', [
                'as'   => 'manager.business.service.show',
                'uses' => 'BusinessServiceController@show',
            ]);
            Route::get('{service}/edit', [
                'as'   => 'manager.business.service.edit',
                'uses' => 'BusinessServiceController@edit',
            ]);
            Route::put('{service}', [
                'as'   => 'manager.business.service.update',
                'uses' => 'BusinessServiceController@update',
            ]);
            Route::delete('{service}', [
                'as'   => 'manager.business.service.destroy',
                'uses' => 'BusinessServiceController@destroy',
            ]);

        });

        // VACANCY RESOURCE
        Route::group(['prefix' => 'vacancy'], function () {
            Route::get('show', [
                'as'   => 'manager.business.vacancy.show',
                'uses' => 'BusinessVacancyController@show',
            ]);
            Route::get('create', [
                'as'   => 'manager.business.vacancy.create',
                'uses' => 'BusinessVacancyController@create',
            ]);
            Route::post('storeBatch', [
                'as'   => 'manager.business.vacancy.storeBatch',
                'uses' => 'BusinessVacancyController@storeBatch',
            ]);
            Route::post('', [
                'as'   => 'manager.business.vacancy.store',
                'uses' => 'BusinessVacancyController@store',
            ]);
        });

    });
});

Route::get('{slug}', [
    'as'   => 'guest.business.home',
    'uses' => 'Guest\BusinessController@getHome',
])->where('slug', '[^_]+.*')->middleware('web');
