<?php

namespace @@Vendor\@@Plugin\Http\Controllers;

use App\Http\Controllers\AbstractMonitorController;
use Illuminate\Http\Request;
use App\Monitor;

class @@PluginController extends AbstractMonitorController
{
    public function create()
    {
        $title = 'New @@Plugin Monitor';
        $model = null;
        return view('@@plugin::save', [
            'title' => $title,
            'model' => $model,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|max:255',
        ]);

        $result = $request->toArray();
        $result['type'] = '@@plugin';
        $monitor = $this->_save($result);
        flash('@@Plugin Monitor created successfully.')->success()->important();
        return redirect("/monitor/{$monitor->id}");
    }

    public function edit($id)
    {
        $monitor = $this->_getMonitor($id);
        $title = 'Edit @@Plugin Monitor';

        return view('@@plugin::save', [
            'title' => $title,
            'model' => $this->transformJson($monitor),
        ]);
    }

    protected function transformJson(Monitor $monitor)
    {
        $obj = new Monitor();
        $obj->id = $monitor->id;
        // fill the object
        return $obj;
    }
}
