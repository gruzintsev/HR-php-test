<?php

namespace App\Exceptions\Weather;

class NoDataException extends YandexAPIException
{
    function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        $message = $message ?: 'Wrong or no data from Yandex Weather API.';
        parent::__construct($message, $code, $previous);
    }
}