<?php

namespace App\Http\Controllers;

use App\Monitor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
        $monitor = $this->get($id);
        $user = Auth::user();
        $code = "{
  \"api_key\": \"{$user->api_key}\",
  \"monitor_key\": \"{$monitor->monitor_key}\",
  \"value\": \"your_value\"
}";
        return view('monitors.show', ['monitor' => $monitor, 'code' => $code]);
    }

    public function ajaxGet(Request $request) {
        $id = $request->input('id');
        $monitor = $this->get($id);
        return response()->json(['monitor' => $monitor, 'ok' => true]);
    }

    private function get($id) {
        return Monitor::findOrFail($id);
    }
}
