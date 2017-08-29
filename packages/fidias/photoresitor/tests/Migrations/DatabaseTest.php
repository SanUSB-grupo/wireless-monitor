<?php

namespace Tests\Migrations;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 *
 */
class DatabaseTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function monitorPackageExists()
    {
        $this->assertDatabaseHas('monitor_packages', ['path' => 'photoresistor']);
    }
}
