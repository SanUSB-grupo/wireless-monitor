<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use League\JsonGuard\Validator;

class TemperatureControllerTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * @test
     */
    public function accessCreate()
    {
        $response = $this->call('GET', '/temperature/create');
        $this->assertEquals(200, $response->status());
        $this->assertViewHas('title');
        $this->assertViewHas('units');
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
