<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class HomeControllerTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    /**
     * @test
     */
    public function index()
    {
        $response = $this->call('GET', '/home');
        $this->assertEquals(200, $response->status());
    }

    /**
     * @test
     */
    public function welcome()
    {
        $response = $this->call('GET', '/');
        $this->assertEquals(200, $response->status());
    }
}
