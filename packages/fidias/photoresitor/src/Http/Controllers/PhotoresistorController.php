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
        $this->_save($result);
        return redirect('/monitor');
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
