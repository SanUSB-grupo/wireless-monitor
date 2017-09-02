<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class MonitorControllerTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    private $user;
    private $monitor;

    public function setUp() {
        parent::setUp();
        $this->user = $this->createUser();
        $data = [
            'description' => 'Temperature Test',
            'min' => 10,
            'max' => 50,
            'type' => 'temperature',
        ];
        $this->monitor = $this->createMonitor($this->user, $data);
    }

    /**
     * @test
     */
    public function index()
    {
        $response = $this->call('GET', '/monitor');
        $response->assertStatus(200);
        $response->assertViewHas('packages');
    }

    /**
     * @test
     */
    public function ajaxList()
    {
        $this->actingAs($this->user);
        $response = $this->call('GET', '/monitor/ajax-list');
        $response->assertStatus(200);
        $content = json_decode($response->getContent());
        $this->assertTrue(array_key_exists('ok', $content));
        $this->assertTrue(array_key_exists('list', $content));
    }

    /**
     * @test
     */
    public function show()
    {
        $this->actingAs($this->user);
        $response = $this->call('GET', "/monitor/{$this->monitor->id}");
        $response->assertStatus(200);
        $response->assertViewHas('monitor');
        $response->assertViewHas('auth_json');
        $response->assertViewHas('example_send');
        $response->assertViewHas('login_cmd');
        $response->assertViewHas('send_cmd');
    }

    /**
     * @test
     */
    public function ajaxGet()
    {
        $this->actingAs($this->user);
        $response = $this->call('GET', '/monitor/ajax-get', ['id' => $this->monitor->id]);
        $response->assertStatus(200);
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
        $this->actingAs($this->user);
        $response = $this->call('GET', '/monitor/ajax-get-measures', [
            'id' => $this->monitor->id,
            'limit' => $limit,
            'order' => 'asc',
        ]);
        $response->assertStatus(200);
        $content = json_decode($response->getContent());
        $this->assertTrue(array_key_exists('ok', $content));
        $this->assertTrue(array_key_exists('items', $content));
    }
}
