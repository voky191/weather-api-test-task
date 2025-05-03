<?php

namespace App\Contracts;

interface WeatherService
{
    public function searchResults(string $query) : array;
}
