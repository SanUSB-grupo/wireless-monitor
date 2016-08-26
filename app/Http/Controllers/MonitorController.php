<?php

namespace App\Http\Controllers;

use App\Monitor;
use Illuminate\Support\Facades\Auth;

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
        return response()->json($list);
    }
}
