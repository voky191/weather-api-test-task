<?php

namespace App\Services\Weather;

use App\Exceptions\WeatherApiErrorException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class ApiService
{
    private array $params = [];

    public function __construct(private readonly string $uri, string $apiKey)
    {
        $this->setParam('key', $apiKey);
    }

    /**
     * @throws WeatherApiErrorException
     * @throws ConnectionException
     */
    public function search(string $query): array
    {

        $this->setParam('q', $query);

        $response = Http::timeout(30)
            ->get($this->uri, $this->params);

        $result = $response->json();

        if ($response->successful()) {
            return $result;
        } else {
            throw new WeatherApiErrorException(array_key_exists('error', $result ?? []) ?
                $result['error']['message'] : __('errors.default'));
        }
    }

    protected function setParam(string $key, string $value): void
    {
        $this->params[$key] = $value;
    }
}
