<?php

namespace Tests\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use League\JsonGuard\Validator;
use App\Monitor;

class BlinkledsControllerTest extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;

    /**
     * @test
     */
    public function accessCreate()
    {
        $response = $this->call('GET', '/blinkleds/create');
        $response->assertStatus(200);
        $response->assertViewHas('colors');
        $response->assertViewHas('title');
    }

    /**
     * @test
     */
    public function create()
    {
        $data = [
            'description' => 'Blink LEDs Test',
            'leds' => [
                [
                    'id' => 'led1',
                    'color' => '#3498db'
                ]
            ]
        ];

        $user = $this->createUser();
        $this->actingAs($user);
        $response = $this->call('POST', '/blinkleds', $data);
        // assert redirect
        $response->assertStatus(302);

        $updated = Monitor::find(1);
        $this->assertEquals('Blink LEDs Test', $updated->data['description']);
        $this->assertEquals('blinkleds', $updated->data['type']);
        $this->assertEquals(1, count($updated->data['leds']));
        $this->assertEquals('led1', $updated->data['leds'][0]['id']);
        $this->assertEquals('#3498db', $updated->data['leds'][0]['color']);
        $this->assertEquals($user->id, $updated->user_id);
    }

    /**
     * @test
     */
    public function edit()
    {
        $user = $this->createUser();
        $data = [
            'description' => 'Blink LEDs Test',
            'leds' => [
                [
                    'id' => 'led1',
                    'color' => '#3498db'
                ]
            ],
            'type' => 'blinkleds',
        ];
        $monitor = $this->createMonitor($user, $data);
        $this->actingAs($user);
        $response = $this->get("/blinkleds/{$monitor->id}/edit");
        $response->assertStatus(200);
        $response->assertViewHas('title');
        $response->assertViewHas('colors');
        $response->assertViewHas('model');
    }

    /**
     * @test
     */
    public function update()
    {
        $user = $this->createUser();
        $data = [
            'description' => 'Blink LEDs Test',
            'leds' => [
                [
                    'id' => 'led1',
                    'color' => '#3498db'
                ]
            ],
            'type' => 'blinkleds',
        ];
        $monitor = $this->createMonitor($user, $data);

        $data['description'] = 'Toggle LEDs Test';
        $data['leds'] = [
            [
                'id' => 'led1',
                'color' => '#18bc9c'
            ],
            [
                'id' => 'led2',
                'color' => '#f39c12'
            ]
        ];
        $data['id'] = "{$monitor->id}";
        $response = $this->actingAs($user)
            ->post('/blinkleds', $data);
        $response->assertStatus(302);
        $response->assertRedirect("/monitor/{$monitor->id}");

        $updated = Monitor::find(1);
        $this->assertEquals($updated->data['description'], 'Toggle LEDs Test');
        $leds = $updated->data['leds'];
        $this->assertEquals('blinkleds', $monitor->data['type']);
        $this->assertEquals(2, count($leds));
        $this->assertEquals('led1', $leds[0]['id']);
        $this->assertEquals('#18bc9c', $leds[0]['color']);
        $this->assertEquals('led2', $leds[1]['id']);
        $this->assertEquals('#f39c12', $leds[1]['color']);
        $this->assertEquals($user->id, $updated->user_id);
    }

    /**
     * @test
     */
    public function validateJsonSchema()
    {
        $json_schema_file = storage_path("app/json-schema/blinkleds.json");
        $contents = file_get_contents($json_schema_file);
        $json_schema_example = storage_path("app/json-schema/blinkleds-example.json");
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
        $json_schema_file = storage_path("app/json-schema/blinkleds.json");
        $contents = file_get_contents($json_schema_file);
        $invalidData = '{"leds_fake":[{"id_fake": "led1", "status": "fake"}]}';
        $data = json_decode($invalidData);
        $schema = json_decode($contents);
        $validator = new Validator($data, $schema);
        $this->assertTrue($validator->fails());
    }
}
