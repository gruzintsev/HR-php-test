<?php

namespace App\Http\Controllers;

use App\Services\Weather\YandexWeatherService;

/**
 * Class WeatherController.
 */
class WeatherController extends Controller
{
    public function index(string $city)
    {
        try {
            $temperature = app(YandexWeatherService::class)->getTemperatureByCity($city);
        } catch (\Exception $exception) {
            $errorMessage = $exception->getMessage();
        }

        return view('weather.city')
            ->with([
                'temperature' => $temperature ?? '?',
                'errorMessage' => $errorMessage ?? '',
                'city' => $city,
            ]);
    }
}