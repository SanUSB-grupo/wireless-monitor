<?php
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
Route::group(['middleware' => ['throttle']], function()
{
	Route::resource('authenticate', 'JWTAuthController', ['only' => ['index']]);
	Route::post('authenticate', 'JWTAuthController@authenticate');
	Route::get('refresh-token', 'JWTAuthController@refreshToken');
    Route::resource('send', 'Api\SendController', ['only' => ['store']]);
});
