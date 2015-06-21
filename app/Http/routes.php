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

Route::get('root', [
    'uses'          => 'RootController@index',
    'middleware'    => ['auth', 'acl'],
    'is'            => 'root']);

Route::resource('businesses', 'BusinessesController');

Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('select/{business_slug}', function ($business_slug) {
    
    try {

    	$business_id = App\Business::where('slug', $business_slug)->first()->id;
    	
    } catch (Exception $e) {

    	return 'error';

    }

    Session::set('selected.business_id', $business_id);

	return $business_id;
});

Route::get('selected', function () {

	$business_id = Session::get('selected.business_id');

	return $business_id;
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

