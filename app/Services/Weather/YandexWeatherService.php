<?php

namespace App\Services\Weather;

use App\Exceptions\Weather\NoDataException;
use GuzzleHttp\Client;
use App\Exceptions\Weather\WrongCityException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class YandexWeatherService implements WeatherInterface
{
    const URL = 'https://api.weather.yandex.ru';
    const VERSION = 'v1';
    const METHOD_FORECAST = 'forecast';
    const CACHE_TIME = 60;

    public static $citiesLocation = [
        'bryansk' => ['lat' => '53.272332', 'lon' => '34.290366'],
        'krasnodar' => ['lat' => '45.0576759', 'lon' => '38.8575906'],
        'antarktida' => ['lat' => '-89.9651218', 'lon' => '-178.5967122'],
    ];

    /**
     * @param string $city
     * @return mixed
     */
    protected static function getPosition(string $city)
    {
        return array_get(self::$citiesLocation, $city);
    }

    /**
     * @param string $city
     * @param array $params
     * @return array
     * @throws WrongCityException
     */
    protected function getWeatherData(string $city, array $params = []): array
    {
        $position = self::getPosition($city);
        if (!$position) {
            throw new WrongCityException;
        }
        $params = array_merge($params, $position);
        $url = $this->getRequestUrl(self::METHOD_FORECAST, $params);

        $jsonData = Cache::remember('weather:' . implode(':', $position), self::CACHE_TIME, function () use ($url) {
            return $this->getRequestData($url);
        });

        return json_decode($jsonData, true);
    }

    /**
     * @param string $url
     * @param array $params
     * @return string
     */
    protected function getRequestUrl(string $url, array $params): string
    {
        $queryParams = empty($params) ? '' : '?' . http_build_query($params);

        return implode('/', [
                self::URL,
                self::VERSION,
                $url,
                $queryParams
            ]
        );
    }

    protected function getRequestData(string $url): string
    {
        $client = new Client();
        $response = $client->get($url, [
            'headers' => ['X-Yandex-API-Key' => config('services.yandex.weather.key')],
            'http_errors' => false,
        ]);

        if ($response->getStatusCode() == Response::HTTP_OK) {
            $data = $response->getBody()->getContents();
        } else {
            $data = null;
        }

        return $data;
    }

    /**
     * @param string $city
     * @return array
     * @throws NoDataException
     * @throws WrongCityException
     */
    public function getWeatherDataByCity(string $city): array
    {
        $data = $this->getWeatherData($city);

        if (empty($data['fact']['temp'])) {
            throw new NoDataException;
        }

        return $data;
    }

    /**
     * @param string $city
     * @return float
     * @throws NoDataException
     * @throws WrongCityException
     */
    public function getTemperatureByCity(string $city): float
    {
        return array_get($this->getWeatherDataByCity($city), 'fact.temp');
    }
}