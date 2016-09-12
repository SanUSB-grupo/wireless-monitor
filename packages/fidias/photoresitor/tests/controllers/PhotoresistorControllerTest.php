<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use \Storage;
use League\JsonGuard\Validator;

class PhotoresistorControllerTest extends TestCase
{
    use WithoutMiddleware;

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
