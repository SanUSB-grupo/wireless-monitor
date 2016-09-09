<?php

namespace Fidias\Blinkleds\Http\Controllers;

use App\Http\Controllers\AbstractMonitorController;
use Illuminate\Http\Request;

class BlinkledsController extends AbstractMonitorController
{
    public function create()
    {
        $title = 'New Blink LEDs Monitor';
        $colors = [
            '#3498db' => 'blue',
            '#18bc9c' => 'green',
            '#f39c12' => 'orange',
            '#e74c3c' => 'red',
            '#9b59b6' => 'violet',
            '#ecf0f1' => 'white',
            '#f1c40f' => 'yellow'
        ];
        return view('blinkleds::save', ['title' => $title, 'colors' => $colors]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|max:255',
            'leds.*.id' => 'required|max:25',
        ], [
            'leds.*.id.required' => 'The LED field is required.',
            'leds.*.id.max' => 'The LED field may not be greater than :max characters.'
        ]);

        $result = $request->toArray();
        $result['type'] = 'blinkleds';
        $this->_save($result);
        return redirect('/monitor');
    }
}
