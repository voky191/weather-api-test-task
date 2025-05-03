<?php

namespace App\Services\Weather;

use App\Contracts\WeatherService;

class ResultService implements WeatherService
{
    public function searchResults(string $query): array
    {
        $api = app(ApiService::class);

        $data = $api->search($query);

        return [
            'city' => $data['location']['name'],
            'country' => $data['location']['country'],
            'temperature' => $data['current']['temp_c'],
            'condition' => $data['current']['condition']['text'],
            'humidity' => $data['current']['humidity'],
            'wind_speed' => $data['current']['wind_kph'],
            'last_updated' => $data['current']['last_updated'],
        ];
    }
}
