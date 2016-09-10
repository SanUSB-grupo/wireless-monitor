<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use \Storage;
use League\JsonGuard\Validator;

class BlinkledsControllerTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * @test
     */
    public function accessCreate()
    {
        $response = $this->call('GET', '/blinkleds/create');
        $this->assertEquals(200, $response->status());
        $this->assertViewHas('colors');
        $this->assertViewHas('title');
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
