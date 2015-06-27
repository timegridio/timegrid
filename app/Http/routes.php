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

Route::resource('manager/businesses', 'BusinessesController');
Route::resource('manager/contacts', 'ContactsController');

Route::get('user/booking/index', ['as' => 'user/booking/index', 'uses' => 'UserBooking@index']);
Route::get('user/booking/book', ['as' => 'user/booking/book', 'uses' => 'UserBooking@book']);
Route::post('user/booking/store', ['as' => 'user/booking/store', 'uses' => 'UserBooking@store']);

Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);

Route::get('/', 'WelcomeController@index');

# Route::get('home', 'HomeController@index');
Route::get('home', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('home/select/{business_slug}', ['as' => 'home/select', 'uses' => 'HomeController@select'] );
Route::get('home/selected', 'HomeController@selected');
Route::get('home/selector', 'HomeController@selector');
Route::get('home/suscriptions', 'HomeController@suscriptions');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

