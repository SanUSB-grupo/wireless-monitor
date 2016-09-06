<?php

namespace Fidias\Photoresistor\Http\Controllers;

use App\Http\Controllers\LoggedInController;

class PhotoresistorController extends LoggedInController
{
    public function create()
    {
        return view('photoresistor::save');
    }
}
