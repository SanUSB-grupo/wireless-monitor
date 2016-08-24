<?php

namespace App\Http\Controllers;

class MonitorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('monitors/index');
    }
}
