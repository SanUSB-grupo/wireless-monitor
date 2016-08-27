<?php

namespace App\Http\Controllers\Monitors;

use App\Http\Controllers\Controller;
use App\Models\Temperature;
use Illuminate\Http\Request;
use App\Monitor;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;

class TemperatureController extends Controller
{
    public function create()
    {
        $model = new Temperature;
        $units = [
            'celcius' => 'Celcius',
            'fahrenheit' => 'Fahrenheit',
            'kelvin' => 'Kelvin'
        ];
        return view('monitors.temperature.save', ['model' => $model,'units' => $units]);
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
        Monitor::create([
            'monitor_key' => Uuid::generate(4),
            'data' => json_encode($result),
            'user_id' => Auth::user()->id,
        ]);
        return view('monitors.index', ['result' => $result]);
    }
}
