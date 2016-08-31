<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use ymon\JWTAuth\PayloadFactory;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;
use App\User;

class JWTAuthController extends Controller
{
    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth', ['except' => ['authenticate']]);
    }

    /**
     *
     * @return Response
     */
    public function index()
    {
        return response()->json(['ok?' => true], 200);
    }

    /**
     * Return a JWT
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $keys = $request->only('api_key', 'monitor_key');
        $credentials = DB::table('users')
                            ->join('monitors', 'users.id', '=', 'monitors.user_id')
                            ->select('users.id', 'users.api_key', 'monitors.monitor_key')
                            ->where([
                                ['users.api_key', '=', $keys['api_key']],
                                ['monitors.monitor_key', '=', $keys['monitor_key']],
                            ])
                            ->first();
        try {
            $user = null;
            $custom_claims = null;
            if (! is_null($credentials)) {
                $user = User::find($credentials->id);
                $custom_claims = [
                    'api_key' => $credentials->api_key,
                    'monitor_key' => $credentials->monitor_key,
                ];
            }
            // verify the credentials and create a token for the user
            if (is_null($credentials) || ! $token = JWTAuth::fromUser($user, $custom_claims)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        // if no errors are encountered we can return a JWT
        return response()->json(compact('token'));
    }
}
