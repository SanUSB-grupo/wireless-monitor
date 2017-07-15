<?php

namespace Fidias\Photoresistor\Http\Controllers;

use App\Http\Controllers\AbstractMonitorController;
use Illuminate\Http\Request;
use App\Monitor;

class PhotoresistorController extends AbstractMonitorController
{
    protected $rules = [
        'description' => 'required|max:255',
        'min' => 'required|numeric',
        'max' => 'required|numeric',
    ];

    public function create()
    {
        $title = 'New Photoresistor Monitor';
        $model = null;
        return view('photoresistor::save', [
            'title' => $title,
            'model' => $model,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $result = $request->toArray();
        $result['type'] = 'photoresistor';
        $monitor = $this->_save($result);
        flash('Photoresistor Monitor created successfully.')->success()->important();
        return redirect("/monitor/{$monitor->id}");
    }

    public function edit($id)
    {
        $monitor = $this->_getMonitor($id);
        $title = 'Edit Photoresistor Monitor';

        return view('photoresistor::save', [
            'title' => $title,
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
        return $obj;
    }
}
