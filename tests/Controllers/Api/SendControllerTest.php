<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Http\Controllers\Api\SendController as Controller;

class SendControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function fetchWithUnauthorizedUser()
    {
        $response = $this->call('POST', '/api/send');
        $this->assertResponseStatus(400);
    }

    /**
     * @test
     *
     * Make auth with valid api_key and monitor_key,
     * Remove monitor from the database,
     * expect that monitor_key doesn't find the monitor.
     */
    public function failToLoadMonitor()
    {
        $user = $this->createUser();
        $monitor = $this->createMonitor($user);

        $token = $this->auth($user->api_key, $monitor->monitor_key);
        $headers = [
            'Authorization' => 'Bearer ' . $token
        ];

        $this->deleteMonitorByKey($monitor->monitor_key);
        $this->json('POST', '/api/send', [], $headers)
            ->seeJsonEquals([
                'error_code' => Controller::ERR_MONITOR_NOT_FOUND,
                'errors' => [
                    'message' => "Monitor Key '$monitor->monitor_key' not found."
                ],
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @test
     *
     * Create a monitor with unknow type,
     * expect that monitor type not supported yet message appears.
     */
    public function failToLoadMonitorType()
    {
        $type = 'Unknow';
        $user = $this->createUser();
        $monitor = $this->createMonitor($user, $type);

        $token = $this->auth($user->api_key, $monitor->monitor_key);
        $headers = [
            'Authorization' => 'Bearer ' . $token
        ];
        $this->json('POST', '/api/send', [], $headers)
            ->seeJsonEquals([
                'error_code' => Controller::ERR_TYPE_NOT_SUPPORTED,
                'errors' => [
                    'message' => "Monitor type '$type' not supported yet."
                ],
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @test
     *
     * Send some wrong temperature data through api,
     * expect that server returns schema validation messages.
     */
    public function failToSaveTemperatureMeasure()
    {
        $user = $this->createUser();
        $monitor = $this->createMonitor($user);
        $token = $this->auth($user->api_key, $monitor->monitor_key);
        $headers = [
            'Authorization' => 'Bearer ' . $token
        ];
        $invalidData = '{value1: "fake"}';
        $params = ['data' => $invalidData];
        $this->json('POST', '/api/send', $params, $headers)
            ->seeJsonStructure([
                'error_code',
                'errors',
                'data'
            ])
            ->assertResponseStatus(400);
    }

    /**
     * @test
     *
     * Send a valid json data to the api,
     * expect that everything goes well.
     */
    public function successfulSaveTemperatureMeasure()
    {
        $user = $this->createUser();
        $monitor = $this->createMonitor($user);
        $token = $this->auth($user->api_key, $monitor->monitor_key);
        $headers = [
            'Authorization' => 'Bearer ' . $token
        ];
        $json_schema_example = storage_path("app/json-schema/temperature-example.json");
        $contents_example = file_get_contents($json_schema_example);
        $params = ['data' => $contents_example];
        $this->json('POST', '/api/send', $params, $headers)
            ->seeJsonStructure([
                'data'
            ])
            ->assertResponseStatus(200);
    }

    private function auth($api_key, $monitor_key) {
        $data = [
            'api_key' => $api_key,
            'monitor_key' => $monitor_key,
        ];
        $response = $this->call('POST', '/api/authenticate', $data);
        $content = json_decode($response->getContent());
        return $content->token;
    }
}
