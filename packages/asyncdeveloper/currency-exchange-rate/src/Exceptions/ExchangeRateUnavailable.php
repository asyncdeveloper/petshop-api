<?php


namespace Asyncdeveloper\CurrencyExchangeRate\Exceptions;

use Illuminate\Validation\ValidationException;

class ExchangeRateUnavailable extends ValidationException
{
    public $status = 500;
}
