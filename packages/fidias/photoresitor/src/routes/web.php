<?php

Route::group(['middleware' => ['web']], function()
{
    Route::resource('photoresistor', '\Fidias\Photoresistor\Http\Controllers\PhotoresistorController');
});
