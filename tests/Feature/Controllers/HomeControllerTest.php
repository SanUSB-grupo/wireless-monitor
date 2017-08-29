<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    /**
     * @test
     */
    public function welcome()
    {
        $response = $this->call('GET', '/');
        $this->assertEquals(200, $response->status());
    }
}
