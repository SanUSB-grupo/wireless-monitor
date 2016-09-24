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
    const ERR_MONITOR_NOT_FOUND = 10;
    const ERR_TYPE_NOT_SUPPORTED = 11;
    const ERR_SCHEMA_FAILED = 12;

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
                'error_code' => self::ERR_MONITOR_NOT_FOUND,
                'errors' => [
                    'message' => "Monitor Key '$monitor_key' not found."
                ]
            ], 400);
        }

        $type = $monitor->data['type'];
        $json_schema_file = "json-schema/{$type}.json";
        if (! Storage::exists($json_schema_file)) {
            return response()->json([
                'error_code' => self::ERR_TYPE_NOT_SUPPORTED,
                'errors' => [
                    'message' => "Monitor type '$type' not supported yet."
                ]
            ], 400);
        }
        $contents = Storage::get($json_schema_file);
        $schema = json_decode($contents);
        if (is_string($request->input('data'))) {
            $data = json_decode($request->input('data'));
        } else {
            $aux = json_encode($request->input('data'));
            $data = json_decode($aux);
        }
        $validator = new Validator($data, $schema);
        if ($validator->passes()) {
            // save data
            Measure::create([
                'monitor_id' => $monitor->id,
                'data' => $data,
            ]);
            return response()->json([
                'data' => $data
            ], 200);
        }
        $errors = [];
        foreach ($validator->errors() as $e) {
            $errors[] = $e->toArray();
        }
        return response()->json([
            'error_code' => self::ERR_SCHEMA_FAILED,
            'errors' => $errors,
            'data' => $data
        ], 400);
    }
}
