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
Route::get('/', 'HomeController@welcome');

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/monitor', 'MonitorController@index');
Route::get('/monitor/ajax-list', 'MonitorController@ajaxList');
Route::get('/monitor/ajax-get', 'MonitorController@ajaxGet');
Route::get('/monitor/ajax-get-measures', 'MonitorController@ajaxGetMeasures');
Route::get('/monitor/{id}', 'MonitorController@show');
