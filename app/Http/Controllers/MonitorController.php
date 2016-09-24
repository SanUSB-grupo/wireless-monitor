<?php

namespace App\Http\Controllers;

use App\Monitor;
use App\MonitorPackage;
use App\Measure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;

class MonitorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $packages = MonitorPackage::where('enabled', true)
                        ->orderBy('description')
                        ->get();
        return view('monitors/index', [
            'packages' => $packages,
        ]);
    }

    public function ajaxList(Request $request) {
        $list = Monitor::where('user_id', Auth::user()->id)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->toArray();
        return response()->json(['ok' => true, 'list' => $list]);
    }

    public function show($id) {
        $user = Auth::user();
        $monitor = $this->get($id, $user);
        $auth_json = "{
  \"api_key\": \"{$user->api_key}\",
  \"monitor_key\": \"{$monitor->monitor_key}\"
}";
        $example_send = "data={\"value\": 56.98}";
        $json_schema_file = "json-schema/{$monitor->data['type']}-example.json";
        if (Storage::exists($json_schema_file)) {
            $example_send = Storage::get($json_schema_file);
        }

        $login_cmd = $this->parseToLoginCmd($user->api_key, $monitor->monitor_key);
        $send_cmd = $this->parseToSendCmd($example_send);

        return view('monitors.show', [
            'monitor' => $monitor,
            'auth_json' => $auth_json,
            'example_send' => $example_send,
            'login_cmd' => $login_cmd,
            'send_cmd' => $send_cmd,
        ]);
    }

    public function ajaxGet(Request $request) {
        $user = Auth::user();
        $id = $request->input('id');
        $monitor = $this->get($id, $user);
        return response()->json(['monitor' => $monitor, 'ok' => true]);
    }

    public function ajaxGetMeasures(Request $request) {
        $id = $request->input('id');
        $limit = (int) $request->input('limit', 30);
        $order = $request->input('order', 'asc');
        $user = Auth::user();
        $list = DB::table('measures')
                    ->join('monitors', 'measures.monitor_id', '=', 'monitors.id')
                    ->join('users', 'monitors.user_id', '=', 'users.id')
                    ->select('measures.*')
                    ->where([
                        ['monitors.id', '=', $id],
                        ['users.id', '=', $user->id]
                    ])
                    ->orderBy('measures.created_at', $order)
                    ->take($limit)
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

    private function parseToLoginCmd($api_key, $monitor_key) {
        return "curl -i -X POST -F 'api_key={$api_key}' -F 'monitor_key={$monitor_key}'";
    }

    private function parseToSendCmd($example_send) {
        $output = str_replace(array(" ", "\r", "\n", "\r\n"), "", $example_send);
        return "curl -i -X POST -H 'Content-Type: application/json' "
            . "-H 'Authorization: Bearer <TOKEN>' -d '{\"data\":{$output}}'";
    }
}
