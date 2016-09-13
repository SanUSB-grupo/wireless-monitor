<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Webpatser\Uuid\Uuid;
use App\Monitor;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function auth()
    {
        $user = $this->createUser();
        $monitor = $this->createMonitor($user);

        $data = [
            'api_key' => $user->api_key,
            'monitor_key' => $monitor->monitor_key,
        ];
        $response = $this->call('POST', 'api/authenticate', $data);
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
        $response = $this->call('POST', 'api/authenticate', $data);
        $this->assertResponseStatus(401);
    }
}
