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
    /**
     * @test
     */
    public function monitorPackageExists()
    {
        $this->seeInDatabase('monitor_packages', ['path' => '@@plugin']);
    }
}
