<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Webpatser\Uuid\Uuid;
use App\Monitor;

class JWTAuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    private $user;
    private $monitor;

    public function setUp() {
        parent::setUp();
        $this->user = $this->createUser();
        $this->monitor = $this->createMonitor($this->user);
    }

    /**
     * @test
     */
    public function auth()
    {
        $response = $this->postAuth();
        $this->assertResponseStatus(200);
        $content = json_decode($response->getContent());
        $this->assertTrue(array_key_exists('token', $content));
    }

    /**
     * @test
     */
    public function authFailed()
    {
        $data = [
            'api_key' => '00000000-ffff-0000-ffff-000000000000',
            'monitor_key' => '00000000-ffff-0000-ffff-000000000000',
        ];
        $response = $this->call('POST', '/api/authenticate', $data);
        $this->assertResponseStatus(401);
    }

    /**
     * @test
     */
    public function refreshToken()
    {
        $response = $this->postAuth();
        $this->assertResponseStatus(200);
        $content = json_decode($response->getContent());

        $headers = [
            'Authorization' => 'Bearer ' . $content->token
        ];

        // refresh token, expect a new one
        $this->json('GET', '/api/refresh-token', [], $headers)
            ->seeJsonStructure([
                'token'
            ]);

        // using the first token, is not valid anymore
        $this->json('GET', '/api/refresh-token', [], $headers)
            ->seeJsonEquals([
                "error" => "token_invalid"
            ]);
    }

    /**
     * @test
     */
    public function malformedToken()
    {
        $data = [
            'api_key' => '',
            'monitor_key' => '********-zzzz-yyyy-wwww-++++++++++++',
        ];
        $this->json('POST', '/api/authenticate', $data)
            ->seeJsonEquals([
                "errors" => [
                    'API KEY not in UUID format.',
                    'Monitor KEY not in UUID format.'
                ]
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @test
     *
     * Test user auth with api_key and monitor_key,
     * then access /api/authenticate via GET to test
     * if the token is valid.
     */
    public function indexGetRequest()
    {
        $response = $this->postAuth();
        $content = json_decode($response->getContent());
        $token = $content->token;
        $headers = [
            'Authorization' => 'Bearer ' . $token
        ];
        $this->json('GET', '/api/authenticate', [], $headers)
            ->seeJsonStructure([
                'monitor_key',
            ])->seeJsonEquals([
                'monitor_key' => $this->monitor->monitor_key->string
            ]);
    }

    private function postAuth()
    {
        $data = [
            'api_key' => $this->user->api_key,
            'monitor_key' => $this->monitor->monitor_key,
        ];
        return $this->call('POST', '/api/authenticate', $data);
    }
}
