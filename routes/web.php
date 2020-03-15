<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layouts.main');
});

Route::resource('orders', 'OrderController')->only(['index', 'edit', 'update']);

Route::prefix('products')->group(function () {
    Route::get('/', 'ProductController@index')->name('products.index');
    Route::post('change-price/{product}', 'ProductController@changePrice')->name('products.change-price');
});

Route::prefix('weather')->group(function () {
    Route::get('{city}', 'WeatherController@index')->name('weather');
});