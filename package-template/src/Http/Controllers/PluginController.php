<?php

namespace @@Vendor\@@Plugin\Http\Controllers;

use App\Http\Controllers\AbstractMonitorController;
use Illuminate\Http\Request;

class @@PluginController extends AbstractMonitorController
{
    public function create()
    {
        $title = 'New @@Plugin Monitor';
        return view('@@plugin::save', ['title' => $title]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|max:255',
        ]);

        $result = $request->toArray();
        $result['type'] = '@@plugin';
        $this->_save($result);
        return view('monitors.index');
    }
}
