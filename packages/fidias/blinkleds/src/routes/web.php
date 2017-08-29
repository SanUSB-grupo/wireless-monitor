<?php

Route::group(['middleware' => ['web']], function()
{
    Route::resource('blinkleds', '\Fidias\Blinkleds\Http\Controllers\BlinkledsController');
});
