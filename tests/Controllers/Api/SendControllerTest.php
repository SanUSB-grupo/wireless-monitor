<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use \JWTAuth;

class SendControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function fetchWithUnauthorizedUser()
    {
        $response = $this->call('POST', '/api/send');
        $this->assertResponseStatus(400);
    }

    /**
     * @test
     */
    public function index()
    {
        $user = $this->createUser();
        $monitor = $this->createMonitor($user);

        $data = [
            'api_key' => $user->api_key,
            'monitor_key' => $monitor->monitor_key,
        ];
        $response = $this->call('POST', 'api/authenticate', $data);
        $content = json_decode($response->getContent());
        $token = $content->token;
        $headers = [
            'Authorization' => 'Bearer ' . $token
        ];
        // accessing JWTAuthController@index
        $this->json('GET', '/api/authenticate', [], $headers)
            ->seeJsonStructure([
                'ok?',
                'monitor_key',
            ]);
    }
}
