<?php

namespace Fidias\Temperature\Http\Controllers;

use App\Http\Controllers\AbstractMonitorController;
use Illuminate\Http\Request;
use App\Monitor;

class TemperatureController extends AbstractMonitorController
{
    protected $rules = [
        'description' => 'required|max:255',
        'min' => 'required|numeric',
        'max' => 'required|numeric',
        'unit' => 'required',
    ];

    protected $units = [
        'celsius' => 'Celsius',
        'fahrenheit' => 'Fahrenheit',
        'kelvin' => 'Kelvin'
    ];

    public function create()
    {
        $title = 'New Temperature Monitor';
        $model = null;

        return view('temperature::save', [
            'title' => $title,
            'model' => $model,
            'units' => $this->units,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $result = $request->toArray();
        $result['type'] = 'temperature';
        $this->_save($result);
        return redirect('/monitor');
    }

    public function edit($id)
    {
        $monitor = $this->_getMonitor($id);
        $title = 'Edit Temperature Monitor';

        return view('temperature::save', [
            'title' => $title,
            'units' => $this->units,
            'model' => $this->transformJson($monitor),
        ]);
    }

    /**
     * Create dynamic monitor based on the JSON data.
     * @param  Monitor $monitor
     * @return Monitor
     */
    protected function transformJson(Monitor $monitor)
    {
        $obj = new Monitor();
        $obj->id = $monitor->id;
        $obj->description = $monitor->data['description'];
        $obj->min = $monitor->data['min'];
        $obj->max = $monitor->data['max'];
        $obj->unit = $monitor->data['unit'];
        return $obj;
    }
}
