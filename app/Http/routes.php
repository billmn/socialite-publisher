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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

// Social routes
Route::get('social/{driver}/login',    ['as' => 'social.login',    'uses' => 'SocialController@login']);
Route::get('social/{driver}/callback', ['as' => 'social.callback', 'uses' => 'SocialController@callback']);
Route::get('social/{driver}/message',  ['as' => 'social.message',  'uses' => 'SocialController@message']);
Route::post('social/{driver}/publish', ['as' => 'social.publish',  'uses' => 'SocialController@publish']);

// Facebook routes
Route::get('social/facebook/pages',         ['as' => 'social.facebook.pages',         'uses' => 'SocialController@facebookPages']);
Route::post('social/facebook/pages/choose', ['as' => 'social.facebook.pages.chooose', 'uses' => 'SocialController@facebookChoosePage']);