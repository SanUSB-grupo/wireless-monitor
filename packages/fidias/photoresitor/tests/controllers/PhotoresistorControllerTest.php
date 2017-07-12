<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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
        $this->assertEquals(200, $response->status());
        $this->assertViewHas('title');
    }

    /**
     * @test
     */
    public function storage()
    {
        $user = $this->createUser();
        $this->actingAs($user);
        $this->visit('/photoresistor/create');
        $this->type('Bedroom Test', 'description');
        $this->type('10', 'min');
        $this->type('45', 'max');
        $this->press('Save');
        $this->seePageIs('/monitor/1');
        $this->see('created successfully');

        $monitor = Monitor::where('id', 1)->first();
        $this->assertEquals($monitor->data['description'], 'Bedroom Test');
        $this->assertEquals($monitor->data['min'], '10');
        $this->assertEquals($monitor->data['max'], '45');
        $this->assertEquals($monitor->user_id, $user->id);
    }

    /**
     * @test
     */
    public function validateJsonSchema()
    {
        $json_schema_file = storage_path("app/json-schema/photoresistor.json");
        $contents = file_get_contents($json_schema_file);
        $json_schema_example = storage_path("app/json-schema/photoresistor-example.json");
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
        $json_schema_file = storage_path("app/json-schema/photoresistor.json");
        $contents = file_get_contents($json_schema_file);
        $invalidData = '{"value2": "fake"}';
        $data = json_decode($invalidData);
        $schema = json_decode($contents);
        $validator = new Validator($data, $schema);
        $this->assertTrue($validator->fails());
    }
}
