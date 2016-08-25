<?php

namespace App\Http\Controllers\Monitors;

use App\Http\Controllers\Controller;
use App\Models\Temperature;
use Illuminate\Http\Request;

class TemperatureController extends Controller
{
    public function create() {
        $model = new Temperature;
        $units = [
            'celcius' => 'Celcius',
            'fahrenheit' => 'Fahrenheit',
            'kelvin' => 'Kelvin'
        ];
        return view('monitors/temperature/save', ['model' => $model,'units' => $units]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'description' => 'required|max:255',
            'min' => 'required|numeric',
            'max' => 'required|numeric',
            'unit' => 'required',
        ]);

        $result = $request->toArray();
        return view('monitors/index', ['result' => $result]);
    }
}
