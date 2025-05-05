<?php

namespace App\Exceptions;

use Exception;

class WeatherApiErrorException extends Exception
{
    protected $code = 500;
}
