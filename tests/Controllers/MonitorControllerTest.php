<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class MonitorControllerTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    /**
     * @test
     */
    public function index()
    {
        $response = $this->call('GET', '/monitor');
        $this->assertEquals(200, $response->status());
        $this->assertViewHas('packages');
    }

    /**
     * @test
     */
    public function ajaxList()
    {
        $user = $this->createUser();
        $this->actingAs($user);
        $response = $this->call('GET', '/monitor/ajax-list');
        $this->assertEquals(200, $response->status());
        $content = json_decode($response->getContent());
        $this->assertTrue(array_key_exists('ok', $content));
        $this->assertTrue(array_key_exists('list', $content));
    }

    /**
     * @test
     */
    public function show()
    {
        $user = $this->createUser();
        $monitor = $this->createMonitor($user);
        $this->actingAs($user);
        $response = $this->call('GET', "/monitor/{$monitor->id}");
        file_put_contents('/tmp/index.html', $response->content());
        $this->assertEquals(200, $response->status());
        $this->assertViewHas('monitor');
        $this->assertViewHas('auth_json');
        $this->assertViewHas('example_send');
        $this->assertViewHas('login_cmd');
        $this->assertViewHas('send_cmd');
    }

    /**
     * @test
     */
    public function ajaxGet()
    {
        $user = $this->createUser();
        $monitor = $this->createMonitor($user);
        $this->actingAs($user);
        $response = $this->call('GET', '/monitor/ajax-get', ['id' => $monitor->id]);
        $this->assertEquals(200, $response->status());
        $content = json_decode($response->getContent());
        $this->assertTrue(array_key_exists('ok', $content));
        $this->assertTrue(array_key_exists('monitor', $content));
    }

    /**
     * @test
     */
    public function ajaxGetMeasures()
    {
        $limit = 30;
        $user = $this->createUser();
        $monitor = $this->createMonitor($user);
        $this->actingAs($user);
        $response = $this->call('GET', '/monitor/ajax-get-measures', [
            'id' => $monitor->id,
            'limit' => $limit,
            'order' => 'asc',
        ]);
        $this->assertEquals(200, $response->status());
        $content = json_decode($response->getContent());
        $this->assertTrue(array_key_exists('ok', $content));
        $this->assertTrue(array_key_exists('items', $content));
    }
}
