<?php

namespace App\Http\Controllers;

use App\Monitor;
use App\Measure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $list = Monitor::all();
        return view('monitors/index', ['list' => $list->toJson()]);
    }

    public function ajaxList() {
        $list = Monitor::where('user_id', Auth::user()->id)
            ->orderBy('updated_at', 'desc')
            ->get();
        return response()->json(['ok' => true, 'list' => $list]);
    }

    public function show($id) {
        $user = Auth::user();
        $monitor = $this->get($id, $user);
        $monitor->data = json_decode($monitor->data, TRUE);
        $auth_json = "{
  \"api_key\": \"{$user->api_key}\",
  \"monitor_key\": \"{$monitor->monitor_key}\"
}";
        $send_json = "data={\"value\": 56.98}";

        return view('monitors.show', [
            'monitor' => $monitor,
            'auth_json' => $auth_json,
            'send_json' => $send_json,
        ]);
    }

    public function ajaxGet(Request $request) {
        $user = Auth::user();
        $id = $request->input('id');
        $monitor = $this->get($id, $user);
        $monitor->data = json_decode($monitor->data, TRUE);
        return response()->json(['monitor' => $monitor, 'ok' => true]);
    }

    public function ajaxGetMeasures(Request $request) {
        $id = $request->input('id');
        $user = Auth::user();
        $list = DB::table('measures')
                    ->join('monitors', 'measures.monitor_id', '=', 'monitors.id')
                    ->join('users', 'monitors.user_id', '=', 'users.id')
                    ->select('measures.*')
                    ->where([
                        ['monitors.id', '=', $id],
                        ['users.id', '=', $user->id]
                    ])
                    ->orderBy('measures.created_at', 'asc')
                    ->take(30)
                    ->get();
        $items = Measure::hydrate($list);

        return response()->json(['items' => $items, 'ok' => true]);
    }

    private function get($id, $user) {
        $monitor = DB::table('monitors')
                    ->join('users', 'monitors.user_id', '=', 'users.id')
                    ->select('monitors.*')
                    ->where([
                        ['monitors.id', '=', $id],
                        ['users.id', '=', $user->id]
                    ])->get();
        return Monitor::hydrate($monitor)[0];
    }
}
