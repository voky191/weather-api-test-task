<?php

namespace Tests\Unit\Weather;

use App\Exceptions\WeatherApiErrorException;
use App\Services\Weather\ApiService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiServiceTest extends TestCase
{
    private string $fakeUri = 'https://api.test.com/v1/current.json';
    private string $fakeApiKey = 'test-api-key';

    /** @test */
    public function returns_weather_data_on_successful_response(): void
    {
        Http::fake([
            "{$this->fakeUri}*" => Http::response([
                'location' => ['name' => 'Lviv', 'country' => 'Ukraine'],
                'current' => ['temp_c' => 23, 'condition' => ['text' => 'Sunny']]
            ], 200),
        ]);

        $service = new ApiService($this->fakeUri, $this->fakeApiKey);

        $result = $service->search('Lviv');

        $this->assertEquals('Lviv', $result['location']['name']);
        $this->assertEquals('Ukraine', $result['location']['country']);
        $this->assertEquals('Sunny', $result['current']['condition']['text']);
    }

    /** @test */
    public function throws_weather_api_error_exception_on_error_response(): void
    {
        Http::fake([
            "{$this->fakeUri}*" => Http::response([
                'error' => ['message' => 'API key has been disabled.']
            ], 401),
        ]);

        $this->expectException(WeatherApiErrorException::class);
        $this->expectExceptionMessage('API key has been disabled.');

        $service = new ApiService($this->fakeUri, $this->fakeApiKey);

        $service->search('Lviv');
    }

    /** @test */
    public function throws_weather_api_error_exception_on_connection_failure(): void
    {
        Http::fake([
            "{$this->fakeUri}*" => fn() => throw new \Illuminate\Http\Client\ConnectionException('Connection failed')
        ]);

        $this->expectException(\Illuminate\Http\Client\ConnectionException::class);

        $service = new ApiService($this->fakeUri, $this->fakeApiKey);

        $service->search('Lviv');
    }
}
