<?php

namespace App\Http\Controllers;

use App\Monitor;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;

class AbstractMonitorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Save a minitor
     * @param  [array] $result array of data, including type
     * @return [App\Monitor]
     */
    protected function _save($result)
    {
        return Monitor::create([
            'monitor_key' => Uuid::generate(4),
            'data' => json_encode($result),
            'user_id' => Auth::user()->id,
        ]);
    }
}
