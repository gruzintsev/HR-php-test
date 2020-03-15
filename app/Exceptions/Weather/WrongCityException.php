<?php

namespace App\Exceptions\Weather;

use App\Services\Weather\YandexWeatherService;

class WrongCityException extends YandexAPIException
{
    function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        $message = $message ?:
            'Location for this city is not available. Available city: ' . implode(', ', array_keys(YandexWeatherService::$citiesLocation));
        parent::__construct($message, $code, $previous);
    }
}