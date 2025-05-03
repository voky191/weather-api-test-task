<?php

namespace App\Http\Controllers\API;

use App\Contracts\WeatherService;
use App\Http\Controllers\Controller;
use App\Http\Requests\WeatherSearchRequest;
use Illuminate\Support\Arr;

class WeatherController extends Controller
{
    public function __construct(public WeatherService $service)
    {}

    public function search(WeatherSearchRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validated = $request->validated();

            $result = $this->service->searchResults(query: Arr::get($validated, 'search'));

            return $this->readResponse($result);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    private function readResponse(array $data): \Illuminate\Http\JsonResponse
    {
        return response()->json($data, 200);
    }

    private function errorResponse(string $error, int $code = 500): \Illuminate\Http\JsonResponse
    {
        return response()->json(['error' => $error], $code);
    }
}
