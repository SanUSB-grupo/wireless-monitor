<?php

namespace Fidias\Photoresistor\Http\Controllers;

use App\Http\Controllers\AbstractMonitorController;
use Illuminate\Http\Request;

class PhotoresistorController extends AbstractMonitorController
{
    public function create()
    {
        $title = 'New Photoresistor Monitor';
        return view('photoresistor::save', ['title' => $title]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|max:255',
            'min' => 'required|numeric',
            'max' => 'required|numeric',
        ]);

        $result = $request->toArray();
        $result['type'] = 'photoresistor';
        $this->_save($result);
        return redirect('/monitor');
    }
}
