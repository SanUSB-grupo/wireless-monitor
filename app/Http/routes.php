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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/monitor', 'MonitorController@index');
Route::get('/monitor/ajax-list', 'MonitorController@ajaxList');
Route::get('/monitor/ajax-get', 'MonitorController@ajaxGet');
Route::get('/monitor/{id}', 'MonitorController@show');
Route::resource('temperature', 'Monitors\TemperatureController');

Route::group(['prefix' => 'api'], function()
{
	Route::resource('authenticate', 'JWTAuthController', ['only' => ['index']]);
	Route::post('authenticate', 'JWTAuthController@authenticate');
    Route::resource('send', 'Api\SendController');
});
