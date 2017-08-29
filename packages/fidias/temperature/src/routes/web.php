<?php

Route::group(['middleware' => ['web']], function()
{
    Route::resource('temperature', '\Fidias\Temperature\Http\Controllers\TemperatureController');
});
