<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Webpatser\Uuid\Uuid;

class UserModelTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function saveUser()
    {
        $user = $this->createUser();
        $this->seeInDatabase('users', ['email' => 'usertest@example.com']);
        // select the user
        $saved = User::where('email', '=', 'usertest@example.com')->first();
        $this->assertEquals($saved->id, 1);
        $this->assertEquals($saved->name, 'user test');
        $this->assertEquals($saved->api_key, $user->api_key);
    }
}
