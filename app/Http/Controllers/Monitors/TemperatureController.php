<?php

namespace App\Http\Controllers\Monitors;

use App\Http\Controllers\AbstractMonitorController;
use App\Models\Temperature;
use Illuminate\Http\Request;

class TemperatureController extends AbstractMonitorController
{
    public function create()
    {
        $title = 'New Temperature Monitor';
        $model = new Temperature;
        $units = [
            'celcius' => 'Celcius',
            'fahrenheit' => 'Fahrenheit',
            'kelvin' => 'Kelvin'
        ];
        return view('monitors.temperature.save', [
            'model' => $model,
            'units' => $units,
            'title' => $title,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|max:255',
            'min' => 'required|numeric',
            'max' => 'required|numeric',
            'unit' => 'required',
        ]);

        $result = $request->toArray();
        $result['type'] = 'temperature';
        $this->_save($result);
        return redirect('/monitor');
    }
}
