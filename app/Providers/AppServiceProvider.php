<?php

namespace App\Providers;

use App\Services\Weather\YandexWeatherService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            YandexWeatherService::class,
            function () {
                return new YandexWeatherService();
            }
        );
    }
}
