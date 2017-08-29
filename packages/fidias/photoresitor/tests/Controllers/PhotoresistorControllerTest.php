<?php

namespace Tests\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use League\JsonGuard\Validator;
use App\Monitor;

class PhotoresistorControllerTest extends TestCase
{
    use WithoutMiddleware, DatabaseMigrations;

    /**
     * @test
     */
    public function accessCreate()
    {
        $response = $this->call('GET', '/photoresistor/create');
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
            'description' => 'Bedroom Test',
            'min' => '10',
            'max' => '45'
        ];
        $response = $this->post('/photoresistor', $data);
        $response->assertStatus(302);
        $response->assertRedirect('/monitor/1');

        $updated = Monitor::find(1);
        $this->assertEquals('Bedroom Test', $updated->data['description']);
        $this->assertEquals('10', $updated->data['min']);
        $this->assertEquals('45', $updated->data['max']);
        $this->assertEquals($user->id, $updated->user_id);
    }

    /**
     * @test
     */
    public function edit()
    {
        $user = $this->createUser();
        $data = [
            'description' => 'Bedroom Test',
            'min' => '10',
            'max' => '45',
            'type' => 'photoresistor',
        ];
        $monitor = $this->createMonitor($user, $data);
        $this->actingAs($user);
        $response = $this->get("/photoresistor/{$monitor->id}/edit");
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
            'description' => 'Bedroom Test',
            'min' => '10',
            'max' => '45',
            'type' => 'photoresistor',
        ];
        $monitor = $this->createMonitor($user, $data);

        $data['description'] = 'Kitchen Test';
        $data['min'] = '20';
        $data['max'] = '50';
        $data['id'] = $monitor->id;
        $response = $this->actingAs($user)
            ->post('/photoresistor', $data);
        $response->assertStatus(302);
        $response->assertRedirect("/monitor/{$monitor->id}");

        $updated = Monitor::find(1);
        $this->assertEquals('Kitchen Test', $updated->data['description']);
        $this->assertEquals('20', $updated->data['min']);
        $this->assertEquals('50', $updated->data['max']);
        $this->assertEquals($user->id, $updated->user_id);
    }

    /**
     * @test
     */
    public function validateJsonSchema()
    {
        $json_schema_file = storage_path('app/json-schema/photoresistor.json');
        $contents = file_get_contents($json_schema_file);
        $json_schema_example = storage_path('app/json-schema/photoresistor-example.json');
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
        $json_schema_file = storage_path('app/json-schema/photoresistor.json');
        $contents = file_get_contents($json_schema_file);
        $invalidData = '{"value2": "fake"}';
        $data = json_decode($invalidData);
        $schema = json_decode($contents);
        $validator = new Validator($data, $schema);
        $this->assertTrue($validator->fails());
    }
}
