<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class HomeControllerTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    /**
     * @test
     */
    public function welcome()
    {
        $response = $this->call('GET', '/');
        $this->assertEquals(200, $response->status());
    }
}
