<?php

Route::group(['middleware' => ['web']], function()
{
    Route::resource('@@plugin', '\@@Vendor\@@Plugin\Http\Controllers\@@PluginController');
});
