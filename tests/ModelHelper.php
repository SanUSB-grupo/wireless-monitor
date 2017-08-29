<?php

namespace Tests;

use App\User;
use App\Monitor;
use Webpatser\Uuid\Uuid;

trait ModelHelper
{
    public function createUser()
    {
        $user = factory(User::class)->create([
            'name' => 'user test',
            'email' => 'usertest@example.com',
            'api_key' => Uuid::generate(4),
            'password' => bcrypt('password'),
        ]);

        return $user;
    }

    public function createMonitor(User $user, $data = ['type' => 'temperature'])
    {
        $monitor = factory(Monitor::class)->create([
            'monitor_key' => Uuid::generate(4),
            'user_id' => $user->id,
            'data' => $data,
        ]);

        return $monitor;
    }

    public function deleteMonitorByKey($monitor_key)
    {
        return Monitor::where('monitor_key', $monitor_key)->delete();
    }
}
