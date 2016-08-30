<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use League\JsonGuard\Validator;
use Storage;
use App\Measure;
use App\Monitor;

class SendController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function store(Request $request)
    {
        $payload = JWTAuth::parseToken()->getPayload();
        $monitor_key = $payload->get('monitor_key');
        $monitor = Monitor::where('monitor_key', $monitor_key)->first();
        if (is_null($monitor)) {
            return response()->json([
                'ok?' => false,
                'errors' => [
                    'message' => "Monitor Key '$monitor_key' not found."
                ]
            ]);
        }
        $monitor_data = json_decode($monitor->data);
        $type = $monitor_data->type;
        $json_schema_file = "json-schema/{$type}.json";
        if (! Storage::exists($json_schema_file)) {
            return response()->json([
                'ok?' => false,
                'errors' => [
                    'message' => "Monitor type '$type' not supported yet."
                ]
            ]);
        }
        $contents = Storage::get($json_schema_file);
        $schema = json_decode($contents);
        $data = json_decode($request->input('data'));
        $validator = new Validator($data, $schema);
        if ($validator->passes()) {
            // save data
            Measure::create([
                'monitor_id' => $monitor->id,
                'data' => $data,
            ]);
            return response()->json(['ok?' => true], 200);
        }
        $errors = [];
        foreach ($validator->errors() as $e) {
            $errors[] = $e->toArray();
        }
        return response()->json([
            'ok?' => false,
            'errors' => $errors
        ]);
    }
}
