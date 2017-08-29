<?php

namespace Fidias\Blinkleds\Http\Controllers;

use App\Http\Controllers\AbstractMonitorController;
use Illuminate\Http\Request;
use App\Monitor;

class BlinkledsController extends AbstractMonitorController
{
    protected $colors = [
        '#3498db' => 'blue',
        '#18bc9c' => 'green',
        '#f39c12' => 'orange',
        '#e74c3c' => 'red',
        '#9b59b6' => 'violet',
        '#ecf0f1' => 'white',
        '#f1c40f' => 'yellow'
    ];

    protected $rules = [
        'description' => 'required|max:255',
        'leds.*.id' => 'required|max:25',
    ];

    public function create()
    {
        $title = 'New Blink LEDs Monitor';
        $model = null;
        return view('blinkleds::save', [
            'title' => $title,
            'model' => $model,
            'colors' => $this->colors
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules, [
            'leds.*.id.required' => 'The LED field is required.',
            'leds.*.id.max' => 'The LED field may not be greater than :max characters.'
        ]);

        $result = $request->toArray();
        $result['type'] = 'blinkleds';
        $monitor = $this->_save($result);
        flash('Blink LEDs Monitor saved successfully.')->success()->important();
        return redirect("/monitor/{$monitor->id}");
    }

    public function edit($id)
    {
        $monitor = $this->_getMonitor($id);
        $title = 'Edit Blink LEDs Monitor';

        return view('blinkleds::save', [
            'title' => $title,
            'colors' => $this->colors,
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
        $obj->leds = $monitor->data['leds'];
        return $obj;
    }
}
