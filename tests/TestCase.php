<?php

use App\User;
use App\Monitor;
use Webpatser\Uuid\Uuid;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    protected function createUser()
    {
        $user = factory(User::class)->create([
            'name' => 'user test',
            'email' => 'usertest@example.com',
            'api_key' => Uuid::generate(4),
            'password' => bcrypt('password'),
        ]);
        return $user;
    }

    protected function createMonitor(User $user)
    {
        $monitor = factory(Monitor::class)->create([
            'monitor_key' => Uuid::generate(4),
            'user_id' => $user->id,
            'data' => '{"value": 10}',
        ]);
        return $monitor;
    }
}
