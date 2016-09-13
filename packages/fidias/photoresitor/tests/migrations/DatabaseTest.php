<?php

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
        $this->seeInDatabase('monitor_packages', ['path' => 'photoresistor']);
    }
}
