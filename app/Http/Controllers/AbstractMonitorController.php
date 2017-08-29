<?php

namespace App\Http\Controllers;

use App\Monitor;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

abstract class AbstractMonitorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Save a monitor
     * @param  [array] $result array of data, including type
     * @return [App\Monitor]
     */
    protected function _save($result)
    {
        unset($result['_token']);
        if (isset($result['id']) && $result['id'] > 0) {
            $id = $result['id'];
            unset($result['id']);
            $monitor = Monitor::find($id);
            if ($monitor->user_id == Auth::id()) {
                $monitor->data = $result;
                $monitor->save();
            }
            return $monitor;
        }
        unset($result['id']);
        return Monitor::create([
            'monitor_key' => Uuid::generate(4),
            'data' => $result,
            'user_id' => Auth::id(),
        ]);
    }

    protected function _getMonitor($id, $user = -1) {
        if ($user == -1) {
            $user = Auth::user();
        }
        $monitor = DB::table('monitors')
                    ->join('users', 'monitors.user_id', '=', 'users.id')
                    ->select('monitors.*')
                    ->where([
                        ['monitors.id', '=', $id],
                        ['users.id', '=', $user->id]
                    ])->get()->all();
        return Monitor::hydrate($monitor)[0];
    }

    /**
     * Transforms the JSON data from Monitor into
     * a dynamic Monitor.
     * @param  Monitor $monitor
     * @return Monitor
     */
    abstract protected function transformJson(Monitor $monitor);
}
