<?php

namespace Asyncdeveloper\CurrencyExchangeRate\Facades;

use Illuminate\Support\Facades\Facade;

class CurrencyExchangeRate extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'currency-exchange-rate';
    }
}
