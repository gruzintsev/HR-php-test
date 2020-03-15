<?php

namespace App\Exceptions\Weather;

class YandexAPIException extends \Exception
{
    function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        $message = $message ?: 'Error from Yandex API';
        parent::__construct($message, $code, $previous);
    }
}