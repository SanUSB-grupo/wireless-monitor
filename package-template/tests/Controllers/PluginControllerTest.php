<?php

namespace Tests\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use League\JsonGuard\Validator;

class @@PluginControllerTest extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;

    /**
     * @test
     */
    public function accessCreate()
    {
        $response = $this->call('GET', '/@@plugin/create');
        $response->assertStatus(200);
        $response->assertViewHas('title');
    }

    /**
     * @test
     */
    public function create()
    {
        $user = $this->createUser();
        $this->actingAs($user);
        $data = [
            'description' => '@@Plugin Test',
            // ...
        ];
        $response = $this->post('/@@plugin', $data);
        $response->assertStatus(302);
        $response->assertRedirect('/monitor/1');

        $updated = Monitor::find(1);
        $this->assertEquals('@@Plugin Test', $updated->data['description']);
        // ...
        $this->assertEquals($user->id, $updated->user_id);
    }

    /**
     * @test
     */
    public function edit()
    {
        $user = $this->createUser();
        $data = [
            'description' => '@@Plugin Test',
            // ...
            'type' => '@@plugin',
        ];
        $monitor = $this->createMonitor($user, $data);
        $this->actingAs($user);
        $response = $this->get("/@@plugin/{$monitor->id}/edit");
        $response->assertStatus(200);
        $response->assertViewHas('title');
        $response->assertViewHas('model');
    }

    /**
     * @test
     */
    public function update()
    {
        $user = $this->createUser();
        $data = [
            'description' => '@@Plugin Test',
            // ...
            'type' => '@@plugin',
        ];
        $monitor = $this->createMonitor($user, $data);

        $data['description'] = '@@Plugin Test 2';
        // ...
        $data['id'] = $monitor->id;
        $response = $this->actingAs($user)
            ->post('/@@plugin', $data);
        $response->assertStatus(302);
        $response->assertRedirect("/monitor/{$monitor->id}");

        $updated = Monitor::find(1);
        $this->assertEquals('@@Plugin Test 2', $updated->data['description']);
        // ...
        $this->assertEquals($user->id, $updated->user_id);
    }

    /**
     * @test
     */
    public function validateJsonSchema()
    {
        $json_schema_file = storage_path("app/json-schema/@@plugin.json");
        $contents = file_get_contents($json_schema_file);
        $json_schema_example = storage_path("app/json-schema/@@plugin-example.json");
        $contents_example = file_get_contents($json_schema_example);

        $schema = json_decode($contents);
        $data = json_decode($contents_example);
        $validator = new Validator($data, $schema);
        $this->assertTrue($validator->passes());
    }

    /**
     * @test
     */
    public function invalidDataJsonSchema()
    {
        $json_schema_file = storage_path("app/json-schema/@@plugin.json");
        $contents = file_get_contents($json_schema_file);
        $invalidData = '{}';
        $data = json_decode($invalidData);
        $schema = json_decode($contents);
        $validator = new Validator($data, $schema);
        $this->assertTrue($validator->fails());
    }
}
