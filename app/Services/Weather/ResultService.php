<?php

namespace App\Services\Weather;

use App\Contracts\WeatherService;
use Illuminate\Support\Facades\Log;

class ResultService implements WeatherService
{
    public function searchResults(string $query): array
    {
        $api = app(ApiService::class);

        $data = $api->search($query);
        $array = $this->dataArray($data);

        Log::channel('weather')
            ->info(date('Y-m-d H:i:s') . " - Погода в {$array['city']}: {$array['temperature']}°C, {$array['condition']}\n");

        return $array;
    }

    private function dataArray($data): array
    {
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
