<?php

namespace Tests\Migrations;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 *
 */
class DatabaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function monitorPackageExists()
    {
        $this->assertDatabaseHas('monitor_packages', ['path' => 'blinkleds']);
    }
}
