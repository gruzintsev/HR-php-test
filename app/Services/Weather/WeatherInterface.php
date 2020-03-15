<?php

namespace App\Services\Weather;

/**
 * Interface WeatherInterface
 * @package App\Services\Weather
 */
interface WeatherInterface
{
    public function getWeatherDataByCity(string $city): array;
}