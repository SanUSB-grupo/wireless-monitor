<?php

namespace Tests\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use League\JsonGuard\Validator;
use App\Monitor;

class TemperatureControllerTest extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;

    /**
     * @test
     */
    public function accessCreate()
    {
        $response = $this->get('/temperature/create');
        $response->assertStatus(200);
        $response->assertViewHas('title');
        $response->assertViewHas('units');
    }

    /**
     * @test
     */
    public function create()
    {
        $user = $this->createUser();
        $this->actingAs($user);
        $data = [
            'description' => 'Laboratory Test',
            'min' => '10',
            'max' => '45',
            'unit' => 'celsius'
        ];
        $response = $this->post('/temperature', $data);
        $response->assertStatus(302);
        $response->assertRedirect('/monitor/1');

        $updated = Monitor::find(1);
        $this->assertEquals('Laboratory Test', $updated->data['description']);
        $this->assertEquals('10', $updated->data['min']);
        $this->assertEquals('45', $updated->data['max']);
        $this->assertEquals('celsius', $updated->data['unit']);
        $this->assertEquals($user->id, $updated->user_id);
    }

    /**
     * @test
     */
    public function edit()
    {
        $user = $this->createUser();
        $data = [
            'description' => 'Temperature Test',
            'min' => 10,
            'max' => 50,
            'unit' => 'celsius',
            'type' => 'temperature',
        ];
        $monitor = $this->createMonitor($user, $data);
        $this->actingAs($user);
        $response = $this->get("/temperature/{$monitor->id}/edit");
        $response->assertStatus(200);
        $response->assertViewHas('title');
        $response->assertViewHas('units');
        $response->assertViewHas('model');
    }

    /**
     * @test
     */
    public function update()
    {
        $user = $this->createUser();
        $data = [
            'description' => 'Temperature Test',
            'min' => 10,
            'max' => 50,
            'unit' => 'celsius',
            'type' => 'temperature'
        ];
        $monitor = $this->createMonitor($user, $data);

        $data['description'] = 'Laboratory Test';
        $data['min'] = '50';
        $data['max'] = '85';
        $data['unit'] = 'fahrenheit';
        $data['id'] = "{$monitor->id}";
        $response = $this->actingAs($user)
            ->post('/temperature', $data);
        $response->assertStatus(302);
        $response->assertRedirect("/monitor/{$monitor->id}");

        $updated = Monitor::find(1);
        $this->assertEquals('Laboratory Test', $updated->data['description']);
        $this->assertEquals('50', $updated->data['min']);
        $this->assertEquals('85', $updated->data['max']);
        $this->assertEquals('fahrenheit', $updated->data['unit']);
        $this->assertEquals($user->id, $updated->user_id);
    }

    /**
     * @test
     */
    public function validateJsonSchema()
    {
        $json_schema_file = storage_path("app/json-schema/temperature.json");
        $contents = file_get_contents($json_schema_file);
        $json_schema_example = storage_path("app/json-schema/temperature-example.json");
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
        $json_schema_file = storage_path("app/json-schema/temperature.json");
        $contents = file_get_contents($json_schema_file);
        $invalidData = '{value1: "fake"}';
        $data = json_decode($invalidData);
        $schema = json_decode($contents);
        $validator = new Validator($data, $schema);
        $this->assertTrue($validator->fails());
    }
}
