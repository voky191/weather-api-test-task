<?php

namespace App\Http\Middleware;

use App\Exceptions\WeatherApiErrorException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckWeatherApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @throws WeatherApiErrorException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = config('weather.api_key');

        if ($key) {
            return $next($request);
        }else {
            return response()->json(__('errors.key'), 500);
        }
    }
}
