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

Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');
Route::get('home/select/{business_slug}', ['as' => 'home/select', 'uses' => 'HomeController@select'] );
Route::get('home/selected', 'HomeController@selected');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

